# WarranTrack

The WarranTrack web app makes it easier for users to keep track of their purchases of products that come with a warranty. Whether it's electronics, vehicles, or any other product, WarranTrack helps users stay organized and informed about their warranty periods.

## Features

- Add product information such as product name, category, purchase date, warranty period, and an image of the receipt.
- Automatically calculate and display the remaining time of the warranty for each product.
- Archive warranties when the warranty period ends, providing a clear overview of expired warranties.
- User-friendly interface for managing and viewing products and warranties.
- Responsive design for optimal usage on both mobile and desktop devices.

## Technologies Used

- HTML / Twig
- CSS
- Symfony (PHP)
- JavaScript
- Docker
- PostgreSQL
- Git

## Installation

Make sure the following tools are installed on your system:

- Docker: [Docker Installation Instructions](https://docs.docker.com/get-docker/)
- Docker Compose: [Docker Compose Installation Instructions](https://docs.docker.com/compose/install/)

To install and set up WarranTrack on your local machine, follow these steps:

1. Clone the repository: `git clone https://github.com/Woocash0/WarranTrack`
2. Navigate to the project directory: `cd your-project`
3. Customize the settings in `.env` if necessary:
4. Start the Docker containers: `docker-compose up -d`  
5. Install PHP dependencies: `docker-compose exec app composer install`
6. Run database migrations: `docker-compose exec app php bin/console doctrine:migrations:migrate`
7. The application should now be accessible at `http://localhost:8000`.

## Screenshots

![Screenshot](screenshots/login-page.png)
![Screenshot](screenshots/login-page-mobile.png)
![Screenshot](screenshots/main-page.png)
![Screenshot](screenshots/main-page-mobile.png)
![Screenshot](screenshots/details.png)
![Screenshot](screenshots/details-mobile.png)

## Entity-Relationship Diagram (ERD)

![ERD Diagram](screenshots/Diagram_ERD.png)

## API Documentation

![API Documentation](screenshots/API_doc.png)

## Contributing

Contributions to WarranTrack are currently not open. However, feel free to fork the repository and make any modifications or improvements for personal use.

## License

This project is currently not licensed.

