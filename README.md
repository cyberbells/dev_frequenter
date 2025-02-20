# Frequenters - Loyalty Platform MVP

Welcome to the **Frequenters** MVP repository! This repository lays the foundation for building a loyalty and engagement platform that connects businesses and customers. Frequenters is designed to help businesses reward repeat customers, attract new ones, and build a vibrant local community.

---
![image](https://github.com/user-attachments/assets/faf3083b-d160-421f-91f4-58dda3da9496)

## Features

### 1. User Roles
- **Customers**:
  - Earn and redeem points for check-ins and purchases.
  - Discover participating businesses and their rewards.
- **Businesses**:
  - Manage points, track customer interactions, and customize rewards.
  - Increase visibility and engagement through the Frequenters platform.

### 2. Points System
- Businesses receive **5,000 points per month** to distribute.
- Customers earn points based on interactions, with **100 points = $1**.
- Flexible options for businesses:
  - **Exclusive Points**: Redeemable only at the issuing business.
  - **Citywide Points**: Redeemable across all participating businesses in the same city.

### 3. Key Platform Features
- **Dynamic Points System**: Businesses set point values for check-ins or purchases.
- **Customer Engagement**: Gamified rewards to encourage repeat visits.
- **Business Customization**: Tailor point allocation to match transaction sizes.

---

## Project Structure

### Database
SQL scripts for creating core tables:
- `users`: Manages authentication and user roles.
- `customer_profiles`: Stores customer-specific data.
- `business_profiles`: Stores business-specific data, including point settings.
- `points`: Logs all points earned and redeemed.

### PHP Files
- **Authentication**:
  - `register.php`: Handles user registration.
  - `login.php`: Processes user logins.
- **Customer App**:
  - `dashboard.php`: Displays points balance and transactions.
  - `customers.php`: Lists customer interactions.
- **Business App**:
  - `set_points_per_checkin.php`: Allows businesses to configure points per check-in.
  - `redeem_points.php`: Processes point redemptions.
  - `business_dashboard.php`: Displays key business metrics.

### HTML Forms
User-friendly forms for interacting with the platform:
- **Customer Registration**: Allows customers to sign up.
- **Business Registration**: Allows businesses to sign up.
- **Points Management**: Forms for adding, redeeming, and managing points.

---

## Getting Started

### Prerequisites
- **Development Environment**: PHP server (e.g., XAMPP, WAMP, LAMP).
- **Database**: MySQL.
- **Optional**: Composer for dependency management.

### Installation

1. **Clone the repository**:
    ```bash
    git clone https://github.com/Frequenters/develop.git
    cd develop
    ```

2. **Set up the database**:
    - Import the provided SQL schema:
      ```bash
      mysql -u [username] -p [database_name] < schema.sql
      ```

3. **Configure the database connection**:
    - Update `db_connect.php` with your credentials:
      ```php
      $servername = "localhost";
      $username = "your_username";
      $password = "your_password";
      $dbname = "frequenters";
      ```

4. **Start the PHP server** and access the platform in your browser.

---

## API Integration

### Available Endpoints
- **Set Points Per Check-In**:
  - `POST /api/business/set-points-per-checkin`
- **Check-In**:
  - `POST /api/points/checkin`
- **Redeem Points**:
  - `POST /api/points/redeem`

Refer to the `API_Documentation.md` file for more details.

---

## Contribution Guidelines

1. **Branch Naming**:
   - Use descriptive branch names (e.g., `feature/points-management`).
2. **Code Style**:
   - Follow PHP and SQL best practices.
3. **Pull Requests**:
   - Ensure all changes are tested before submission.
4. **Issues**:
   - Use the GitHub Issues tab to report bugs or suggest features.

---

## Next Steps

- **Dynamic QR Codes**: Implement for secure check-ins.
- **OAuth Integration**: Add login support for Google, Facebook, and Snapchat.
- **Responsive Design**: Develop customer and business app interfaces for mobile and web.

---

## License

This project is licensed under the **MIT License**. See the `LICENSE` file for more details.

---

### Let’s build the future of customer loyalty together! 🚀
