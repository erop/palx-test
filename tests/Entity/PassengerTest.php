<?php

namespace App\Test\Entity;

use App\Entity\Card;
use App\Entity\Metro;
use App\Entity\Passenger;
use App\Entity\PassengerDoNotHaveEnoughMoneyException;
use App\Entity\Station;
use App\Entity\Turnstile\InOutTurnstile;
use App\Entity\Turnstile\InTurnstile;
use App\Entity\Turnstile\OutTurnstile;
use App\Entity\Turnstile\Turnstile;
use App\Event\InTurnstileEvents;
use App\State\Turnstile\InOutTurnstileLocked;
use App\State\Turnstile\InOutTurnstileUnlocked;
use App\State\Turnstile\InTurnstileLocked;
use App\State\Turnstile\InTurnstileUnlocked;
use PHPUnit\Framework\TestCase;

class PassengerTest extends TestCase
{
    /**
     * @var Passenger
     */
    private $passenger;

    public function testPassengerMustHaveACard(): void
    {
        $this->assertInstanceOf(Card::class, $this->passenger->getCard());
    }

    public function testPassengerCanHaveNumericBalanceOnCard(): void
    {
        $this->assertIsNumeric($this->passenger->getCardBalance());
    }

    public function topUpAmounts(): array
    {
        return [
            [256, 123],
            [700, 456],
        ];
    }

    public function testPassengerMustBeAbleToTopUpTheCardIfHasEnoughMoney(): void
    {
        $money = 200;
        $topUpAmount = 60;
        $this->passenger->earn($money);
        $this->passenger->topUpCard($topUpAmount);
        $this->assertEquals($topUpAmount, $this->passenger->getCardBalance());
    }

    public function testPassengerCanNotTopUpCardIfHasNoEnoughMoney(): void
    {
        $money = 100;
        $topUpAmount = 120;
        $this->passenger->earn($money);
        $this->expectException(PassengerDoNotHaveEnoughMoneyException::class);
        $this->passenger->topUpCard($topUpAmount);
    }

    public function testPassengerCanHaveMoney(): void
    {
        $this->assertIsNumeric($this->passenger->getMoney());
    }

    public function earnedMoney(): array
    {
        return [
            [100],
            [200],
        ];
    }

    /**
     * @dataProvider earnedMoney
     */
    public function testPassengerCanEarnMoney($amount)
    {
        $this->passenger->earn($amount);
        $this->assertEquals($amount, $this->passenger->getMoney());
    }

    public function testPassengerCanSpendMoney(): void
    {
        $moneyToEarn = 123;
        $moneyToSpend = 456;
        $deficit = -($moneyToEarn - $moneyToSpend);
        $this->expectException(PassengerDoNotHaveEnoughMoneyException::class);
        $this->expectExceptionMessage(sprintf(
                'You need %d more money to spend amount of %d',
                $deficit,
                $moneyToSpend)
        );
        $this->passenger->earn($moneyToEarn);
        $this->passenger->spend($moneyToSpend);
    }

    public function testPassengerCanNotSpendMoreMoneyThanItHas(): void
    {
        $moneyToEarn = 456;
        $moneyToSpend = 123;
        $this->passenger->earn($moneyToEarn);
        $this->passenger->spend($moneyToSpend);
        $this->assertEquals($moneyToEarn - $moneyToSpend, $this->passenger->getMoney());
    }

    public function testPassengerEarnsSomeMoneyTwiceAndSpendOnce()
    {
        $firstAmount = 123;
        $secondAmount = 456;
        $moneyToSpend = 234;
        $this->passenger->earn($firstAmount);
        $this->passenger->earn($secondAmount);
        $this->passenger->spend($moneyToSpend);
        $this->assertEquals($firstAmount + $secondAmount - $moneyToSpend, $this->passenger->getMoney());
    }

    public function testPassengerDecidedToSpendTooMuchMoney(): void
    {
        $this->expectException(PassengerDoNotHaveEnoughMoneyException::class);
        $firstAmount = 123;
        $secondAmount = 456;
        $moneyToSpend = 1000;
        $this->passenger->earn($firstAmount);
        $this->passenger->earn($secondAmount);
        $this->passenger->spend($moneyToSpend);
    }

    public function testPassengerCanChooseEnterableStation(): Station
    {
        $metro = new Metro();
        $station1 = new Station('Mayakovskaya');
        $station1->addTurnstiles(new InTurnstile(), new InOutTurnstile(), new OutTurnstile());
        $station2 = new Station('Tverskaya');
        $station2->addTurnstiles(new OutTurnstile());
        $metro->addStations($station1, $station2);
        $availableStations = $this->passenger->chooseEnterableStations($metro);
        $this->assertEquals(1, count($availableStations));
        return $availableStations[0];

    }

    protected function setUp(): void
    {
        $this->passenger = new Passenger();
    }

    /**
     * @param Station $station
     * @depends testPassengerCanChooseEnterableStation
     */
    public function testPassengerCanPassThroughTheTurnstile(Station $station): void
    {
        $this->passenger->earn(100);
        $this->passenger->topUpCard(60);
        /** @var InTurnstileEvents|Turnstile $turnstile */
        $turnstile = $this->passenger->chooseEnterableTurnstiles($station)[0];
        $this->passenger->applyCardTo($turnstile);
        $this->assertContains(get_class($turnstile->getState()), [InTurnstileUnlocked::class, InOutTurnstileUnlocked::class]);
        $this->passenger->comeInsideThrough($turnstile);
        $this->assertContains(get_class($turnstile->getState()), [InTurnstileLocked::class, InOutTurnstileLocked::class]);
    }

}
