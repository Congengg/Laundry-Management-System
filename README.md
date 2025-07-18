
# Laundry-Management-System
DAD MINI PROJECT

Introduction

The Laundry Management System is an online platform built to make it easier for people to manage their laundry. Instead of calling or visiting a laundry shop, customers can simply log in, choose a laundry package, place an order, make a payment, and check their order status, all from one website. The system is designed to make the laundry process more convenient, especially for people with busy schedules.

What makes this system special is how everything works smoothly in real time. When a customer places an order, they are immediately shown their updated order list. The system also allows them to choose from different payment methods, such as online banking, credit card, or even cash on delivery. This helps make the whole experience easier and more flexible for the customer.

The platform also includes a simple but important security feature. It checks whether a customer is logged in before showing any content. If not, it automatically redirects them to the login page. This keeps the user’s information safe and ensures that only registered customers can access their orders.

All the packages shown on the website are loaded from the server using background code. This means the page does not need to reload every time a change is made, which makes it faster and smoother to use. When customers submit their orders or view their past orders, the system communicates with the server behind the scenes to get or send the data. This is what makes the website feel modern and responsive.

There is also a useful search feature in the “My Orders” section. Customers can look up their orders using an order ID or their phone number. This helps them easily find past orders without having to scroll through everything.

Overall, the Laundry Service System helps both customers and laundry businesses. It saves time, reduces errors, and creates a better experience for everyone.



System Architecture

High-Level Diagram: A visual representation (e.g., a block diagram) showing how all components interact: the two frontend apps, the backend server, the database, and any external services. This provides a clear overview of the distributed system.

![HLD](https://github.com/user-attachments/assets/a9ab18d9-e789-41af-9a1a-00685e4279fc)


Backend Application

Technology Stack: List the programming language, framework (e.g., Node.js with Express, Python with Django), and other key libraries used.

API Documentation: This is the most critical part. It should include:

1. GET /api/customers
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

2. POST /api/orders
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

3. GET /api/orders/{order_id}
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

4. PUT /api/orders/{order_id}
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

5. POST /api/couriers
    Method: POST
    
    Description: Register a new courier.
    
    Request Parameters:
    
    Body (JSON):
    
    {
      "username": "courier1",
      "password": "password123",
      "phone": "01964827589"
    }
    Response Example:
    
    
    {
      "courier_id": 1,
      "username": "courier1",
      "phone": "01964827589",
      "status": "available"
    }
    Error Response Example (Missing Fields):
    
    {
      "error": "Username and phone are required"
    }
    Status Code:
    
    201 Created for successful registration.
    
    400 Bad Request if required fields are missing.

6. Security
    JWT (JSON Web Tokens):
    
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

Entity-Relationship Diagram (ERD):

![laundry database](https://github.com/user-attachments/assets/67de73f0-490b-48b7-be79-8420eb016c25)




The database schema for the laundry service system is designed to efficiently track customer orders, payments, packages, and couriers. The customers table serves as the central entity, linking to the orders table, which tracks the details of each order, including the selected package and its status. Each order is linked to a payment record, ensuring that payment details are associated with specific orders. The packages table defines the available laundry services, while the couriers table manages the delivery personnel, with each order being assigned a courier for delivery. This one-to-many relationship structure ensures seamless tracking of customers, their orders, payments, and deliveries, streamlining the operational workflow of the laundry service.



Use Case Diagrams/Flowcharts: 

Place Order Flowchart:

![Cust](https://github.com/user-attachments/assets/b39054f7-f35b-4f0d-8f5e-72e836b3bcd6)

Track Order Flowchart:

![Order](https://github.com/user-attachments/assets/fcf680e1-cb26-4aba-8f86-1c8b12edafc3)

Place Order Flowchart: Describes the steps a customer takes to select a package, input pickup details, confirm the order, and finish the process.

Track Order Flowchart: Describes the steps for checking and updating the order status, with the ability for both the customer and the courier to track the order.

Data Validation: 

Frontend Validation: Ensures all required fields are filled before submitting.

Backend Validation: Ensures no duplicate orders and verifies customer existence.
