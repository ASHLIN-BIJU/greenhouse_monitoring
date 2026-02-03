#!/bin/bash

# Configuration
BASE_URL="http://localhost:8000/api"
EMAIL="test_$(date +%s)@example.com"
PASSWORD="password123"

echo "--------------------------------"
echo "Testing Passport Authentication"
echo "--------------------------------"
echo "User Email: $EMAIL"
echo ""

# 1. Register
echo "[1/4] Registering User..."
REGISTER_RESPONSE=$(curl -s -X POST "$BASE_URL/register" \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d "{
           \"name\": \"Test User\",
           \"email\": \"$EMAIL\",
           \"password\": \"$PASSWORD\",
           \"password_confirmation\": \"$PASSWORD\"
         }")

echo "$REGISTER_RESPONSE" | jq . || echo "$REGISTER_RESPONSE"
echo ""

# 2. Login
echo "[2/4] Logging in..."
LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL/login" \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d "{
           \"email\": \"$EMAIL\",
           \"password\": \"$PASSWORD\"
         }")

echo "$LOGIN_RESPONSE" | jq . || echo "$LOGIN_RESPONSE"

TOKEN=$(echo "$LOGIN_RESPONSE" | jq -r '.access_token' 2>/dev/null)

if [ "$TOKEN" == "null" ] || [ -z "$TOKEN" ]; then
    echo "Error: Failed to get Access Token"
    exit 1
fi

echo "Token received: ${TOKEN:0:20}..."
echo ""

# 3. Access Protected Route
echo "[3/4] Accessing Protected Route (/api/user)..."
USER_RESPONSE=$(curl -s -X GET "$BASE_URL/user" \
     -H "Authorization: Bearer $TOKEN" \
     -H "Accept: application/json")

echo "$USER_RESPONSE" | jq . || echo "$USER_RESPONSE"
echo ""

# 4. Logout
echo "[4/4] Logging out..."
LOGOUT_RESPONSE=$(curl -s -X POST "$BASE_URL/logout" \
     -H "Authorization: Bearer $TOKEN" \
     -H "Accept: application/json")

echo "$LOGOUT_RESPONSE" | jq . || echo "$LOGOUT_RESPONSE"
echo ""

echo "--------------------------------"
echo "Testing Completed"
echo "--------------------------------"
