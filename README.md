# Financial Tracking App

## Overview
This application helps customers track their financial transactions, including deposits and withdrawals, while offering incentives such as bonuses or dividends for keeping funds in the system. Users can view detailed summaries and reports of their financial activities.

## Problem Solved
Customers needed a reliable way to monitor their financial data online, specifically tracking money earned and withdrawn over time. This system provides a user-friendly solution to manage and visualize these transactions efficiently.

## Features
- Record and track deposits and withdrawals.
- Calculate and display bonuses/dividends for funds retained in the system.
- Generate summary reports for financial overview.
- User-friendly interface for easy navigation and data access.

## Technologies Used
- **PHP**: Backend logic and server-side processing.
- **MySQL**: Database for storing transaction and user data.
- **CSS**: Styling for a responsive and visually appealing interface.
- **JavaScript / Vue.js**: Dynamic frontend for interactive user experiences.

## Installation
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/vincevel/OmnipoolFundManager.git
   ```
2. **Navigate to the Project Directory**:
   ```bash
   cd OmnipoolFundManager
   ```
3. **Set Up the Database**:
   - Create a MySQL database (e.g., `financial_app`).
   - Import the provided `schema.sql` file to set up the necessary tables:
     ```bash
     mysql -u your-username -p financial_app < schema.sql
     ```
4. **Configure Environment**:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update `.env` with your database credentials and other configurations:
     ```env
     DB_HOST=localhost
     DB_NAME=financial_app
     DB_USER=your-username
     DB_PASS=your-password
     ```
5. **Install Dependencies**:
   - Ensure PHP and Composer are installed.
   - Run the following to install PHP dependencies:
     ```bash
     composer install
     ```
   - For frontend dependencies (Vue.js), run:
     ```bash
     npm install
     ```
6. **Set Up Web Server**:
   - Configure your web server (e.g., Apache or Nginx) to point to the `public/` directory.
   - For example, in Apache, set the `DocumentRoot` to `/path/to/your-repo-name/public`.
7. **Run the Application**:
   - Start your web server and access the app via `http://localhost` or your configured domain.
   - Optionally, use PHP's built-in server for development:
     ```bash
     php -S localhost:8000 -t public
     ```
8. **Build Frontend Assets** (if using Vue.js):
   - Compile Vue.js assets:
     ```bash
     npm run dev
     ```

## Usage
- Log in or register as a user.
- Record deposits and withdrawals through the dashboard.
- View incentives (bonuses/dividends) for retained funds.
- Access summary reports to analyze financial activity.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue to discuss improvements or bugs.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
