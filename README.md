#FizzBuzz

To run the application:

```shell
php index.php -h
```

This will print the help message, displaying the options.

If you want to print out the numbers as per the challenge:

```shell
php index.php -p
```

You can also override the default number (100) by attaching an integer right after the "p" option

```shell
php index.php -p200
```

To run the tests:
```shell
./vendor/bin/phpunit tests
```

##Notes
I have committed the vendors, which I don't like. Only because I didn't want to make you run composer install. 
I wouldn't commit the vendors in a real project :D

This solution might be way too over-engineered for the task, but I had fun and I wanted to show what I am good at. So I built kind of a small CLI framework.

##Things I Didn't Do

- I could do tests for each of the components and each of the exceptions
- .gitignore
- There was no need for injecting service within others, but you can do that in this implementation with the "@" notation (check Container.php). Otherwise, I went with the Symfony way to get the service inside the controllers by calling the container directly. An alternative would be to define injections for each controller separately.