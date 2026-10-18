<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Departure;
use App\Models\Participant;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->orderBy('id')->get();
        $next = 0;

        $departures = Departure::with('activity')->orderBy('starts_at')->get();

        foreach ($departures as $departure) {
            if ($departure->status === 'cancelled') {
                continue;
            }

            $bookingsWanted = fake()->numberBetween(1, 3);

            for ($b = 0; $b < $bookingsWanted; $b++) {
                $adults = fake()->numberBetween(1, 2);
                $teens = fake()->numberBetween(0, 1);
                $children = $departure->activity->min_age <= 4
                    ? fake()->numberBetween(0, 2)
                    : 0;

                if ($adults + $teens + $children > $departure->availableSeats()) {
                    continue;
                }

                $status = $this->statusFor($departure);

                $booking = Booking::factory()->create([
                    'user_id' => $customers[$next++ % $customers->count()]->id,
                    'departure_id' => $departure->id,
                    'status' => $status,
                ]);

                $this->createParticipants($booking, $adults, $teens, $children);
                $booking->refreshTotals();

                if ($status !== 'confirmed') {
                    continue;
                }

                $this->createPayments($booking, $departure);

                if ($departure->status === 'completed' && fake()->boolean(60)) {
                    Review::factory()->create(['booking_id' => $booking->id]);
                }
            }
        }
    }

    private function statusFor(Departure $departure): string
    {
        return match ($departure->status) {
            'completed' => fake()->randomElement(['confirmed', 'confirmed', 'confirmed', 'cancelled', 'rejected']),
            'in_progress' => 'confirmed',
            default => fake()->randomElement(['pending', 'confirmed', 'confirmed']),
        };
    }

    private function createParticipants(Booking $booking, int $adults, int $teens, int $children): void
    {
        $groups = [
            ['adult', $adults],
            ['teen', $teens],
            ['twelveOrUnder', $children],
        ];

        foreach ($groups as [$state, $count]) {
            if ($count > 0) {
                Participant::factory()
                    ->count($count)
                    ->{$state}()
                    ->create(['booking_id' => $booking->id]);
            }
        }
    }

    private function createPayments(Booking $booking, Departure $departure): void
    {
        $totalCents = (int) round(((float) $booking->total_price) * 100);
        $paidAt = $departure->starts_at->copy()->subDays(15);

        if ($departure->status === 'open' && fake()->boolean(40)) {
            // Salida futura pagada en dos plazos: señal pagada y resto pendiente.
            $depositCents = (int) round($totalCents * 0.3);

            Payment::factory()->paid()->create([
                'booking_id' => $booking->id,
                'amount' => $this->toDecimal($depositCents),
                'paid_at' => $paidAt,
            ]);

            Payment::factory()->create([
                'booking_id' => $booking->id,
                'amount' => $this->toDecimal($totalCents - $depositCents),
            ]);

            return;
        }

        Payment::factory()->paid()->create([
            'booking_id' => $booking->id,
            'amount' => $this->toDecimal($totalCents),
            'paid_at' => $paidAt,
        ]);
    }

    private function toDecimal(int $cents): string
    {
        return number_format($cents / 100, 2, '.', '');
    }
}
