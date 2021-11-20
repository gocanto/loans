<?php

declare(strict_types=1);

namespace App\Http\Controllers\Loans;

use App\Models\Loan;
use App\Models\User;
use App\Transformers\LoansTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        /** @var Loan $loan */
        $loan = Loan::query()->create($this->getData($user, $request));

        return new JsonResponse(
            $this->transformer->transform($loan),
            JsonResponse::HTTP_CREATED
        );
    }

    private function getData(User $user, Request $request): array
    {
        $validAmount = static function (string $attribute, mixed $value, callable $fail) {
            if (((float) $value) < 1) {
                $fail('The '.$attribute.' has to be grater than 0.');
            }
        };

        $data = $request->validate([
            'description' => ['required', 'string', 'bail'],
            'lent_amount' => ['required', $validAmount, 'bail'],
            'payment_term' => ['required', 'string', Rule::in(\array_keys(Loan::TERMS)), 'bail'],
            'payment_frequency' => ['required', 'string', Rule::in([Loan::DEFAULT_FREQUENCY]), 'bail'],
        ]);

        return \array_merge($data, [
            'user_id' => $user->id,
            'uuid' => Str::uuid()->toString(),
        ]);
    }
}
