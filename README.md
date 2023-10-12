# API Documentation

This document provides an overview of the APIs available in this project. Below, you'll find a list of endpoints and brief descriptions of their functionality.

## Registration and Authentication

### Register User
- **URL**: `/register`
- **Method**: `POST`
- **Description**: Register a new user.
- **Request Parameters**:
  - `name` (string, required): User's name.
  - `email` (string, required): User's email.
  - `password` (string, required): User's password.
- **Response**: JSON response with user information and access token.

### User Login
- **URL**: `/login`
- **Method**: `POST`
- **Description**: Log in an existing user.
- **Request Parameters**:
  - `email` (string, required): User's email.
  - `password` (string, required): User's password.
- **Response**: JSON response with user information and access token.

### User Logout
- **URL**: `/logout`
- **Method**: `POST`
- **Description**: Log out the authenticated user.
- **Middleware**: Requires authentication (Bearer Token).
- **Response**: JSON response indicating a successful logout.

## Authenticated Routes

The following routes require authentication using Bearer Token.

### Get Album by ID
- **URL**: `/album/{id}`
- **Method**: `GET`
- **Description**: Get information about an album by its ID.
- **Response**: JSON response with album information.

### Get Artist by ID
- **URL**: `/artist/{id}`
- **Method`: `GET`
- **Description`: Get information about an artist by their ID.
- **Response`: JSON response with artist information.

### Search
- **URL**: `/search`
- **Method`: `GET`
- **Description`: Search for albums, artists, or other items.
- **Request Parameters**:
  - `query` (string, required): The search query.
- **Response**: JSON response with search results.

## Usage

To access authenticated routes, you need to include the Bearer Token in your request headers.

Example using cURL:
```bash
curl -X GET -H "Authorization: Bearer YOUR_ACCESS_TOKEN" http://your-api-url/album/1
