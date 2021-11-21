# Todo

- [x] Check that the Loans' endpoint are working as expected.
- [x] Add a basic token protection for the loans endpoints.
- [x] Track the installments once loans are created.
- [x] Complete the users endpoints.
- [x] Add Loans tests.
- [ ] Complete read me + instructions.

# Endpoints

```bash
+----------+---------------------------------------------------------------------------+------------------------------------------------------------+
| Method   | URI                                                                       | Action                                                     |
+----------+---------------------------------------------------------------------------+------------------------------------------------------------+
| GET|HEAD | api/loans                                                                 | App\Http\Controllers\Loans\IndexController@handle          |
| GET|HEAD | api/loans/users                                                           | App\Http\Controllers\Loans\UsersController@handle          |
| GET|HEAD | api/loans/users/{uuid}                                                    | App\Http\Controllers\Loans\UserLoansController@handle      |
| POST     | api/loans/users/{uuid}                                                    | App\Http\Controllers\Loans\StoreUserLoansController@handle |
| GET|HEAD | api/users/{userUuid}/loans                                                | App\Http\Controllers\Users\LoansController@handle          |
| GET|HEAD | api/users/{userUuid}/loans/{loanUuid}                                     | App\Http\Controllers\Users\ShowLoanController@handle       |
| POST     | api/users/{userUuid}/loans/{loanUuid}/installments/{installmentUuid}/pay | App\Http\Controllers\Users\PayInstallmentController@handle |
| GET|HEAD | sanctum/csrf-cookie                                                       | Laravel\Sanctum\Http\Controllers\CsrfCookieController@show |
+----------+---------------------------------------------------------------------------+------------------------------------------------------------+
```
