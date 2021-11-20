# Todo

- [ ] Check that the Loans' endpoint are working as expected.
- [ ] Add a basic token protection for the loans endpoints.
- [ ] Track the installments once loans are created.
- [ ] Complete the users endpoints.
- [ ] Add some tests.
- [ ] Complete read me + instructions.
- [ ] Check doc and find missing points if any.

# Endpoints

```bash
+----------+----------------------------------------------------------+-----------------+------------------------------------------------------------+------------------------------------------+
| Method   | URI                                                      | Name            | Action                                                     | Middleware                               |
+----------+----------------------------------------------------------+-----------------+------------------------------------------------------------+------------------------------------------+
| GET|HEAD | api/loans                                                | index           | App\Http\Controllers\Loans\IndexController@handle          | api                                      |
|          |                                                          |                 |                                                            | App\Http\Middleware\AdminUsersMiddleware |
| GET|HEAD | api/loans/users/{uuid}                                   | user.loan       | App\Http\Controllers\Loans\UserLoansController@handle      | api                                      |
|          |                                                          |                 |                                                            | App\Http\Middleware\AdminUsersMiddleware |
| POST     | api/loans/users/{uuid}                                   | store.user.loan | App\Http\Controllers\Loans\StoreUserLoansController@handle | api                                      |
|          |                                                          |                 |                                                            | App\Http\Middleware\AdminUsersMiddleware |
| POST     | api/users/{userUuid}/installments/{installmentUuid}/paid | pay.installment | App\Http\Controllers\Users\PayInstallmentController@handle | api                                      |
| GET|HEAD | api/users/{userUuid}/loan/{loanUuid}                     | loan            | App\Http\Controllers\Users\LoanController@handle           | api                                      |
| POST     | api/users/{uuid}/installments                            | installments    | App\Http\Controllers\Users\InstallmentsController@handle   | api                                      |
| GET|HEAD | api/users/{uuid}/loans                                   | loans           | App\Http\Controllers\Users\LoansController@handle          | api                                      |
+----------+----------------------------------------------------------+-----------------+------------------------------------------------------------+------------------------------------------+
```
