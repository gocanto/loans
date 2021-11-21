## About it

This repository contains a simple API playground that allows you to create Loans on behalf given users. It also allows 
for marking given loans installments as paid.

## Installation

This app uses [Composer](https://getcomposer.org) to manage its dependencies. So, before using it, make sure you have it 
installed in your machine. Once you have done this, you will be able to install this app in by typing the following commands 
in your terminal.

First, you need to open your terminal and position yourself the directory you have chosen to close these files. Once
you have done this, you would be able to type the following from within your working directory: 

```bash
git@github.com:gocanto/loans.git

make install
```

> Please read [more](https://makefiletutorial.com) about make files.

## Environment

The app would use the provided [environment](https://github.com/gocanto/loans/blob/main/.env.example) information. If you 
would like to adjust these values, make sure you update the mentioned file before running the `make install` command. 
It also uses MySQL as its DB engine, therefore, you would need to have it installed in your machine too.

In the case you need to adjust the DB credentials, you would need to update these [fields](https://github.com/gocanto/loans/blob/main/.env.example#L14-L16) in your env file in order for
the API to work as expected.

Also, this app ships with testing data out off the box in order for you to start testing the endpoints. Please, follow 
this [link](https://github.com/gocanto/loans/blob/main/database/seeders/DatabaseSeeder.php#L13) to see the seeded values 
that are populated after running the `make install` command.

Lastly, the authentication token to hit the admin endpoint can be found [here](https://github.com/gocanto/loans/blob/main/config/loans.php#L12).
So you would be authorized to request information from these resources.

## Testing Data

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
