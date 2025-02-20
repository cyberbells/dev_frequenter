# Frequenters Platform API Documentation

This document outlines the APIs available for the Frequenters Platform, their purposes, endpoints, request parameters, and expected responses. It is divided into sections based on functionality.

## Authentication APIs

### Customer Registration

Endpoint: /api/register/customer

Method: POST

Description: Registers a new customer.

Parameters:

name (string, required): Customer's full name.

email (string, required): Customer's email address.

password (string, required): Password for the account.

password_confirmation (string, required): Confirm password.

zip_code (string, required): Customer's zip code.

radius (integer, optional): Search radius.

Additional profile information as applicable.

Response:

200 OK with customer profile details on success.

422 Unprocessable Entity with validation errors on failure.

### Business Registration

Endpoint: /api/register/business

Method: POST

Description: Registers a new business.

Parameters:

name (string, required): Business name.

email (string, required): Business email address.

password (string, required): Password for the account.

password_confirmation (string, required): Confirm password.

industry_type (string, required): Type of business (e.g., "Retail", "Salon").

Additional profile information as applicable.

Response:

200 OK with business profile details on success.

422 Unprocessable Entity with validation errors on failure.

### Customer Login

Endpoint: /api/login

Method: POST

Description: Logs in a customer.

Parameters:

email (string, required): Customer's email address.

password (string, required): Customer's password.

Response:

200 OK with authentication token on success.

401 Unauthorized on failure.

### Business Login

Endpoint: /api/login

Method: POST

Description: Logs in a business.

Parameters:

email (string, required): Business email address.

password (string, required): Business password.

Response:

200 OK with authentication token on success.

401 Unauthorized on failure.

## Customer APIs

### Customer Dashboard

Endpoint: /api/customer/dashboard

Method: GET

Description: Fetches details of the customer's dashboard, including check-in history and rewards.

Response:

200 OK with customer dashboard data.

### Customer QR Code for Check-In

Endpoint: /api/generate-qr/customer

Method: GET

Description: Generates a QR code for customer check-ins.

Response:

200 OK with the QR code image as a base64 string.

### Redeem Reward QR Code

Endpoint: /api/rewards/{reward_id}/redeem-qr

Method: GET

Description: Generates a QR code for redeeming a reward.

Parameters:

reward_id (integer, required): ID of the reward being redeemed.

Response:

200 OK with the QR code image and redemption details.

### Search Businesses

Endpoint: /api/customer/search

Method: GET

Description: Searches for businesses based on customer preferences.

Parameters:

query (string, optional): Search query for business name or type.

zip_code (string, optional): Filter businesses by location.

Response:

200 OK with a list of matching businesses.

## Business APIs

### Business Dashboard

Endpoint: /api/business/dashboard

Method: GET

Description: Fetches the business dashboard with points summary and reward analytics.

Response:

200 OK with business dashboard data.

### Manage Points Per Check-In

Endpoint: /api/business/checkin-points

Method: POST

Description: Updates the number of points given to customers per check-in.

Parameters:

points_per_checkin (integer, required): Number of points.

Response:

200 OK on successful update.

### Create Rewards

Endpoint: /api/business/rewards

Method: POST

Description: Creates a new reward for the business.

Parameters:

reward_name (string, required): Name of the reward.

points_required (integer, required): Points required to redeem the reward.

valid_from (date, optional): Start date for the reward.

valid_until (date, optional): End date for the reward.

usage_limit (integer, optional): Maximum redemptions allowed.

Response:

201 Created on success.

### Business QR Code for Check-In

Endpoint: /api/generate-qr/business

Method: GET

Description: Generates a QR code for business check-in verification.

Response:

200 OK with the QR code image as a base64 string.

### Check-In APIs

Customer Check-In

Endpoint: /api/checkin/customer

Method: POST

Description: Registers a customer check-in at a business.

Parameters:

customer_id (integer, required): ID of the customer.

business_id (integer, required): ID of the business.

Response:

200 OK on successful check-in.

400 Bad Request for invalid check-ins.

## Reward APIs

### View Available Rewards

Endpoint: /api/business/{business_id}/rewards

Method: GET

Description: Lists all rewards offered by a specific business.

Parameters:

business_id (integer, required): ID of the business.

Response:

200 OK with a list of rewards.

### Redeem Reward

Endpoint: /api/rewards/{reward_id}/redeem

Method: POST

Description: Redeems a reward for a customer.

Parameters:

reward_id (integer, required): ID of the reward.

customer_id (integer, required): ID of the customer redeeming the reward.

Response:

200 OK on successful redemption.

400 Bad Request for invalid redemptions.

This document will be updated as new APIs are developed and tested.

