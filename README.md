
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

(1) A list of all API endpoints (e.g., /api/books, /api/users/login).

(2) The HTTP method for each endpoint (GET, POST, PUT, DELETE).

(3) Required request parameters, headers, and body formats (with JSON examples).

(4) Example success and error responses (with status codes and JSON examples).

(5) Security: Detail the security measures implemented. Explain the choice of mechanism (e.g., JWT, OAuth 2.0, API Keys) and describe how it protects the endpoints.


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
