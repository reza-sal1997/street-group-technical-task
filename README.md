Laravel Homeowner Name Parser

This Laravel application provides a robust service for parsing homeowner name strings from an uploaded CSV file. It intelligently splits full name strings into structured data, including title, first name, middle name, and last name. The service is designed to handle a variety of common name formats, such as single individuals, multiple people, and couples with shared surnames.
Features

    Parses Complex Name Strings: Accurately deconstructs names into structured PersonDTO objects.

    Handles Multiple Formats:

        Single individuals (Mr John F Doe)

        Multiple, distinct individuals (Mr John Doe and Mrs Jane Smith)

        Couples with shared surnames (Mr and Mrs Doe, Dr & Mrs John Smith)

    Flexible Separators: Recognizes both and and & as separators.

    Input Normalization: Automatically trims excess whitespace for cleaner processing.

    CSV File Upload: Simple web interface to upload a list of names.

    Fully Tested: Includes a comprehensive suite of unit tests to ensure parsing accuracy.

How It Works

The user uploads a CSV file via a web form. The application expects the file to have a header row (which is automatically skipped) and a single column containing the full name strings of the homeowners.

For each row, the HomeownerNameParserService is invoked. It applies a series of rules to dissect the name string and returns an array of one or more PersonDTO objects, which contain the structured name data.
Example Parsing Logic

Input String


Parsed Output (Array of PersonDTOs)

Prof Jane Doe


[title: 'Prof', first_name: 'Jane', initial: null, last_name: 'Doe']

Mr John Doe & Mrs Jane Smith


[title: 'Mr', first_name: 'John', initial: null, lastName: 'Doe'],
[title: 'Mrs', first_name: 'Jane', initial: null, lastName: 'Smith']


Mr and Mrs Smith

[title: 'Mr', first_name: null, initial: null, lastName: 'Smith'],
[title: 'Mrs', first_name: null, initial: null, lastName: 'Smith']
Getting Started
Prerequisites

    PHP >= 8.2

    Composer

    A web server (Laravel Herd, Valet, or php artisan serve)

Installation

    Clone the repository:

    git clone https://github.com/reza-sal1997/street-group-technical-task.git
    cd street-group-technical-task

    Install dependencies:

    composer install

    Set up your environment file:

    cp .env.example .env

    Generate an application key:

    php artisan key:generate

Usage

    Start the local development server:

    php artisan serve

    Navigate to the application's upload page in your web browser http://127.0.0.1:8000/.

    Select a CSV file .

Running Tests

This project includes a suite of unit tests to verify the functionality of the HomeownerNameParserService. To run the tests, execute the following command from the project root:

php artisan test

You can also run the specific parser tests with:

php artisan test --filter HomeownerNameParserServiceTest

Key Components

    app/Services/HomeownerNameParserService.php: Contains all the core logic for parsing name strings.

    app/DTOs/PersonDTO.php: A simple Data Transfer Object to hold the structured name data.

    app/Http/Controllers/HomeOwnerController.php: Handles the file upload request and invokes the parser service.
