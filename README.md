# Laundry-Management-System
DAD MINI PROJECT

Introduction

Project Overview:
The Laundry App is designed to simplify the laundry process for customers by providing a platform to schedule pickups, select laundry packages, and manage payments. Customers can easily order laundry services, and couriers can efficiently manage their schedules to meet customer demands. The app aims to streamline the laundry service, saving time for users while ensuring high-quality laundry handling.

Commercial Value / Third-Party Integration: 
The laundry app has the potential to disrupt the current market by offering convenience through technology. The app can integrate with external services like Google Maps API for real-time address validation and pickup location mapping. These integrations improve user experience, enhance data accuracy, and ensure smooth coordination between customers and couriers.

System Architecture

High-Level Diagram: A visual representation (e.g., a block diagram) showing how all components interact: the two frontend apps, the backend server, the database, and any external services. This provides a clear overview of the distributed system.


+-------------------+      +---------------------+      +---------------------+
| Frontend App 1    | <--> | Backend Application | <--> | MySQL Database      |
| (Customer App)    |      | (PHP with Laravel)   |      |                     |
+-------------------+      +---------------------+      +---------------------+
                                  | 
                                  |
                                  v
                        +---------------------+
                        | External Services   |
                        | (Google Maps)       |
                        +---------------------+


Backend Application

Technology Stack: Language: PHP

Framework: Laravel 

Database: MySQL

External APIs: Google Maps API (for location tracking)

API Documentation: This is the most critical part. It should include:

(1) GET /api/customers
Method: GET

Description: Fetch customer details.

Request Parameters:

Headers:

Authorization: Bearer <JWT>

Query Parameters:

customer_id (optional): The ID of the customer whose details you wish to fetch.

Response Example:

{
  "customer_id": 1,
  "username": "customer1",
  "phone": "01236784120",
  "created_at": "2025-07-11T05:34:09"
}
Error Response Example (Unauthorized):

{
  "error": "Unauthorized"
}
Status Code:

200 OK for successful retrieval.

401 Unauthorized if the JWT is invalid or expired.


(2) POST /api/orders
Method: POST

Description: Place a new laundry order.

Request Parameters:

Body (JSON):


{
  "customer_id": 1,
  "pickup_address": "123 Street, City",
  "pickup_time": "2025-07-18T16:00:00",
  "package_id": 1
}
Response Example:


{
  "order_id": 47,
  "status": "pending",
  "message": "Order placed successfully"
}
Error Response Example (Missing Fields):


{
  "error": "Missing required fields"
}
Status Code:

201 Created for a successful order placement.

400 Bad Request if required fields are missing.

(3) GET /api/orders/{order_id}
Method: GET

Description: Fetch details of a specific order.

Request Parameters:

Path Parameters:

order_id: The ID of the order to retrieve.

Headers:

Authorization: Bearer <JWT>

Response Example:

{
  "order_id": 47,
  "customer_id": 1,
  "pickup_address": "123 Street, City",
  "pickup_time": "2025-07-18T16:00:00",
  "status": "pending",
  "package_id": 1,
  "created_at": "2025-07-17T02:31:38"
}
Error Response Example (Order Not Found):

{
  "error": "Order not found"
}
Status Code:

200 OK for successful retrieval.

404 Not Found if the order doesn't exist.



(4)  PUT /api/orders/{order_id}
Method: PUT

Description: Update the details or status of an existing order.

Request Parameters:

Path Parameters:

order_id: The ID of the order to update.

Body (JSON):

{
  "pickup_address": "456 New Street, City",
  "status": "completed"
}
Response Example:

{
  "order_id": 47,
  "status": "completed",
  "message": "Order updated successfully"
}
Error Response Example (Invalid Status):

{
  "error": "Invalid status value"
}
Status Code:

200 OK for successful update.

400 Bad Request for invalid data (e.g., wrong status).

(5) JWT (JSON Web Tokens):

JWT is used for authentication across the API. It is required for accessing most of the endpoints, such as GET /api/customers, GET /api/orders/{order_id}, and PUT /api/orders/{order_id}.

How it works: When a user logs in (using username and password), the system generates a JWT that is returned to the client. For subsequent API requests, the client must include this token in the Authorization header as Bearer <JWT>.

Protection: JWT helps protect sensitive data by ensuring that only authenticated users can access certain resources. The tokens are signed, ensuring the integrity of the data, and can be expired after a set duration to enhance security.



Frontend Applications

For each of the two frontend apps:

Customer App
Purpose: This app allows customers to place orders, track their laundry, and view order statuses.

Technology Stack: React, Axios for API requests.

API Integration: Communicates with the backend via REST API, using JWT tokens for authentication.

Courier App
Purpose: This app is designed for couriers to manage their assigned orders, update statuses, and track completed deliveries.

Technology Stack: React Native (for mobile), Axios for API requests.

API Integration: Similar to the customer app, the courier app uses REST APIs to interact with the backend for real-time updates on order assignments and deliveries.

Database Design

Entity-Relationship Diagram (ERD): A diagram showing the database tables, their columns (with data types), and the relationships between them (one-to-one, one-to-many).
+-------------+     +-------------+     +-----------+     +-----------+
| customers   |<--> | orders     |<--> | packages  |<--> | couriers  |
+-------------+     +-------------+     +-----------+     +-----------+
     |                  |                   |
     v                  v                   v
+------------+    +------------+       +------------+
| order_status|    | transactions|
+------------+    +------------+


Schema Justification: 
Customers Table: Stores customer details for easy order tracking and management.

Orders Table: Links customers to their laundry orders and associates them with a specific package and courier.

Packages Table: Contains information about available laundry packages (Basic, Deluxe, Premium).

Couriers Table: Manages courier profiles and availability for order fulfillment.

Business Logic and Data Validation

Use Case Diagrams/Flowcharts: Illustrate the main user flows, such as "selecting a book," "borrowing a book," and "returning a book." This visually demonstrates the business logic.
Place Order Use Case:
+-------------------+     +------------------------+     +------------------------+     +---------------------+
|       Start       |---> |   Select Laundry       |---> |   Input Pickup Details |---> |   Confirm Order     |
+-------------------+     +------------------------+     +------------------------+     +---------------------+
                                          |                               |
                                          v                               v
                                    +---------------+                +-------------+
                                    |   End         |                |   End       |
                                    +---------------+                +-------------+

Track Order Use Case:
+-------------------+     +-------------------+     +--------------------+     +-------------------+
|       Start       |---> |   Check Order     |---> |   Update Status    |---> | Track by Customer |
+-------------------+     +-------------------+     +--------------------+     +-------------------+
                                         |                              |
                                         v                              v
                                    +----------------+              +------------------+
                                    |   End          |              |    End           |
                                    +----------------+              +------------------+



Data Validation: 
Frontend Validation: Checks for empty fields in customer registration and order placement (e.g., ensuring all fields are filled before submission).

Backend Validation: Ensures no duplicate orders or invalid data (e.g., verifying that the customer exists before placing an order).
