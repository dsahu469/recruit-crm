# Recruit CRM - Assignment

This README provides details about the API endpoints, authentication, and other related information for the project.

## Table of Contents

- [Authentication](#authentication)
- [Endpoints](#endpoints)
- [Authorization](#authorization)
- [Pagination](#pagination)
- [Search](#search)
- [Error Handling](#error-handling)

## Authentication

- Only JWT Token authentication is allowed.
- Access tokens and refresh tokens are used for authentication.
- Reference: [What Are Refresh Tokens and How to Use Them Securely](https://auth0.com/blog/refresh-tokens-what-are-they-and-when-to-use-them/)

## Endpoints

1. **POST - /v1/token/refresh** - Get new access token
   - Purpose: To get a new access token

2. **POST - /v1/register** - Sign up a user
   - Purpose: To sign up a user

3. **POST - /v1/logout** - Invalidate refresh token
   - Purpose: To invalidate the refresh token

4. **POST - /v1/login** - Get access & refresh token
   - Purpose: To get an access token and refresh token

5. **POST - /v1/candidates** - Save a candidate
   - Purpose: To save a candidate

6. **GET - /v1/candidates/{id}** - Get a specific candidate
   - Purpose: To retrieve a specific candidate

...

## Authorization

- Certain endpoints require authenticated access using JWT tokens.
- Authenticated endpoints: /v1/logout, /v1/token/refresh, /v1/candidates, /v1/candidates/{id}, /v1/candidates/{id} (HTTP methods vary)

## Pagination

- Pagination is implemented for specific endpoints returning multiple items.
- Pagination parameters: page, per_page

## Search

- Searching candidates is supported with pagination.
- Endpoint: POST - /v1/candidates/search
- Pagination parameters: page, per_page
- Search parameters: keyword, department, min_salary, max_salary

## Error Handling

- Detailed error responses are provided for invalid requests.
- HTTP status codes and descriptive error messages are included in responses.

---

For more details, please refer to the detailed API documentation available at http://localhost:8080/docs.

For additional questions or support, contact [Your Contact Information].