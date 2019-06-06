<?php

namespace App\Test\Entity;

use App\Entity\Passenger;
use App\Entity\Turnstile\InOutTurnstile;
use App\Entity\Turnstile\InTurnstile;
use App\Entity\Turnstile\OutTurnstile;
use App\Entity\Turnstile\ProhibitedActionException;
use App\State\Turnstile\InOutTurnstileUnlocked;
use App\State\Turnstile\InTurnstileLocked;
use App\State\Turnstile\InTurnstileUnlocked;
use App\State\Turnstile\OutTurnstileUnlocked;
use PHPUnit\Framework\TestCase;

class TurnstileTest extends TestCase
{
    public function testTurnstileMustBeInAState(): void
    {
        $turnstile = new InTurnstile(new InTurnstileLocked());
        $this->assertContains(get_class($turnstile->getState()),
            [InTurnstileLocked::class, InTurnstileUnlocked::class]);
    }

    /**
     * @depends testPassengerCanEarnMoneyAndTopUpCard
     * @param Passenger $passenger
     */
    public function testUnlockedStateAfterApplyingCard(Passenger $passenger): void
    {
        $turnstile = new InTurnstile();
        $this->assertInstanceOf(InTurnstileLocked::class, $turnstile->getState());
        $passenger->applyCardTo($turnstile);
        $this->assertEquals(30, $passenger->getCardBalance());
        $this->assertInstanceOf(InTurnstileUnlocked::class, $turnstile->getState());
        $passenger->comeInsideThrough($turnstile);
        $this->assertInstanceOf(InTurnstileLocked::class, $turnstile->getState());
    }

    public function testPassengerCanEarnMoneyAndTopUpCard(): Passenger
    {
        $money = 100;
        $topUpAmount = 60;
        $passenger = new Passenger();
        $passenger->earn($money);
        $passenger->topUpCard($topUpAmount);
        $this->assertEquals($money - $topUpAmount, $passenger->getMoney());
        $this->assertEquals($topUpAmount, $passenger->getCardBalance());
        return $passenger;
    }

    /**
     * @param Passenger $passenger
     * @depends testPassengerCanEarnMoneyAndTopUpCard
     */
    public function testPassengerCanComeInThroughInOutTurnstile(Passenger $passenger): void
    {
        $turnstile = new InOutTurnstile();
        $passenger->applyCardTo($turnstile);
        $this->assertInstanceOf(InOutTurnstileUnlocked::class, $turnstile->getState());
        $passenger->comeInsideThrough($turnstile);
    }

    /**
     * @param Passenger $passenger
     * @depends testPassengerCanEarnMoneyAndTopUpCard
     */
    public function testPassengerCanNotPassThroughWithoutPayment(Passenger $passenger): void
    {
        $turnstile = new InTurnstile();
        $this->expectException(ProhibitedActionException::class);
        $passenger->comeInsideThrough($turnstile);
        $passenger->applyCardTo($turnstile);
        $passenger->comeInsideThrough($turnstile);
        $this->assertInstanceOf(InTurnstileLocked::class, $turnstile->getState());
    }

    /**
     * @depends testPassengerCanEarnMoneyAndTopUpCard
     * @param Passenger $passenger
     */
    public function testPassengerCanFreelyComeOutWithInOutTurnstile(Passenger $passenger): void
    {
        $turnstile = new OutTurnstile();
        $passenger->approachFromInside($turnstile);
        $this->assertInstanceOf(OutTurnstileUnlocked::class, $turnstile->getState());
    }


}
