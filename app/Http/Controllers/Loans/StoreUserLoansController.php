<?php

declare(strict_types=1);

namespace App\Http\Controllers\Loans;

use App\Entities\Frequency;
use App\Models\Loan;
use App\Models\User;
use App\Transformers\LoansTransformer;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

final class StoreUserLoansController
{
    public function __construct(private LoansTransformer $transformer)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->where('uuid', $request->route('uuid'))->first();

        if ($user === null) {
            return new JsonResponse([
                'message' => 'The given user [uuid] was not found.'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $loan = $this->create($request, $user);

        return new JsonResponse(
            $this->transformer->transform($loan),
            JsonResponse::HTTP_CREATED
        );
    }

    private function create(Request $request, User $user): Loan
    {
        /** @var Loan $loan */
        $loan = Loan::query()->create($this->getData($request, $user));

        $this->createInstallments($loan);

        return $loan;
    }

    private function createInstallments(Loan $loan): void
    {
        $frequency = Loan::defaultPaymentFrequency(); //weekly

        $amount = $loan->lent_amount / $frequency->installments;
        $date = CarbonImmutable::now();

        for ($i=0; $i < $frequency->installments; $i++) {
            $loan->installments()->create([
                'due_date' => $date->addWeeks($i + 1),
                'uuid' => Str::uuid()->toString(),
                'due_amount' => $amount,
            ]);
        }
    }

    private function getData(Request $request, User $user): array
    {
        $validAmount = static function (string $attribute, mixed $value, callable $fail) {
            if (((float) $value) < 1) {
                $fail('The '.$attribute.' has to be grater than 0.');
            }
        };

        $validFrequencies = Loan::paymentFrequencies();

        $data = $request->validate([
            'description' => ['required', 'string', 'bail'],
            'lent_amount' => ['required', $validAmount, 'bail'],
            'payment_term' => ['required', 'string', Rule::in(\array_keys(Loan::paymentTerms())), 'bail'],
            'payment_frequency' => ['required', 'string', Rule::in(\array_keys($validFrequencies)), 'bail'],
        ]);

        /** @var Frequency $frequency */
        $frequency = Arr::get($validFrequencies, $data['payment_frequency']); //weekly

        return \array_merge($data, [
            'user_id' => $user->id,
            'uuid' => Str::uuid()->toString(),
            'payment_installments' => $frequency->installments,
        ]);
    }
}
