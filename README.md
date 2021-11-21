## About it

This repository contains a simple API playground that allows you to create Loans on behalf given users. It also allows 
for marking given loans installments as paid.

## Installation

This app uses [Composer](https://getcomposer.org) to manage its dependencies. So, before using it, make sure you have it 
installed in your machine. Once you have done this, you will be able to install this app in by typing the following commands 
in your terminal.

Once you have done so, you need to open your terminal and position yourself the directory you have chosen to close these files. Once
you have done this, you would be able to type the following from within your working directory: 

```bash
git@github.com:gocanto/loans.git

cd loans

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

## The app

As mentioned before, this app offers the ability to track users loans and have them able to pay for them through installments. 
The way how it controls the installment is making used of the [Fixed Strategy](https://github.com/gocanto/loans/blob/main/app/Models/Loan.php#L70-L80) to compute due amounts.

Also, it makes use [frequency strategies](https://github.com/gocanto/loans/blob/main/app/Models/Loan.php#L90) to compute given 
loans installments payment dates. Thus, this can be scaled as needed in future versions. 

Given that `weekly` is the only available frequency, installments due dates will be calculated from within loans creation 
date forward [adding as many weeks](https://github.com/gocanto/loans/blob/main/app/Http/Controllers/Loans/StoreUserLoansController.php#L53) as specified in the frequency body

## Permissions

Creating loans should be managed from somebody who works (loans manager for instance) inside a given organization that makes use of this API. Therefore, 
the `Loans resources` holds a [basic/manual](https://github.com/gocanto/loans/blob/main/app/Http/Middleware/AdminUsersMiddleware.php) 
admin authentication to prevent these endpoints to be accessed for apps that are not authorized.

While the users resources are endpoints meant to be accessed by all subscribed users. Hence, those endpoints do not required any authentication token

## Admin Endpoints

```bash
+----------+--------------------------------------------------------------------------+------------------------------------------------------------+
| Method   | URI                                                                      | Action                                                     |
+----------+--------------------------------------------------------------------------+------------------------------------------------------------+
| GET|HEAD | api/loans                                                                | App\Http\Controllers\Loans\IndexController@handle          |
| GET|HEAD | api/loans/users                                                          | App\Http\Controllers\Loans\UsersController@handle          |
| GET|HEAD | api/loans/users/{uuid}                                                   | App\Http\Controllers\Loans\UserLoansController@handle      |
| POST     | api/loans/users/{uuid}                                                   | App\Http\Controllers\Loans\StoreUserLoansController@handle |
+----------+--------------------------------------------------------------------------+------------------------------------------------------------+
```

> see definitions [here](https://github.com/gocanto/loans/blob/main/routes/api.php#L10)

## Users Endpoint

```bash
+----------+--------------------------------------------------------------------------+------------------------------------------------------------+
| Method   | URI                                                                      | Action                                                     |
+----------+--------------------------------------------------------------------------+------------------------------------------------------------+
| GET|HEAD | api/users/{userUuid}/loans                                               | App\Http\Controllers\Users\LoansController@handle          |
| GET|HEAD | api/users/{userUuid}/loans/{loanUuid}                                    | App\Http\Controllers\Users\ShowLoanController@handle       |
| POST     | api/users/{userUuid}/loans/{loanUuid}/installments/{installmentUuid}/pay | App\Http\Controllers\Users\PayInstallmentController@handle |
+----------+--------------------------------------------------------------------------+------------------------------------------------------------+
```

> see definitions [here](https://github.com/gocanto/loans/blob/main/routes/api.php#L20)

## Postman collections

In case you would like to see  how the available endpoints work right out the box, you can [click here](https://github.com/gocanto/loans/blob/main/resources/postman/loans-playground.postman_collection.json) 
in order for you to download the available collections shipped with this application.

For more comprehensive examples, you can visit our [test site](https://github.com/gocanto/loans/tree/main/tests). 

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance its functionality.

## License

The MIT License (MIT). Please see [License File](https://github.com/gocanto/loans/blob/main/LICENSE) for more information.

## How can I thank you?

Why not star this GitHub repository and share its link on your social network?

> Don't forget to [follow me on twitter](https://twitter.com/gocanto)!


