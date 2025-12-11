#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

# Source bashrc to get gcloud function (if available)
if [ -f ~/.bashrc ]; then
    source ~/.bashrc
fi

# --- Configuration ---
PROJECT_ID="gymhubtech-67e6f"
SERVICE_NAME="gym-management-api"
IMAGE_NAME="gcr.io/${PROJECT_ID}/${SERVICE_NAME}:latest"
REGION="asia-southeast1" # IMPORTANT: Choose your desired region!

# --- Environment Variables (CRITICAL for Laravel) ---
# It's BEST PRACTICE to manage these as secrets in Google Secret Manager
# or via CI/CD environment variables, rather than hardcoding them here.

# Replace with your actual Laravel APP_KEY (run 'php artisan key:generate --show' locally)
APP_KEY="base64:eXyAz7Zj3cKaWXV6SQkv65zLQBmLxruM0EtwL1mfFjg="

# Replace with your actual database connection details (e.g., from Cloud SQL)
DB_CONNECTION="mysql"
DB_HOST="34.124.193.124" # e.g., 10.0.0.4 or project:region:instance-name
DB_DATABASE="gym-management-db"
DB_USERNAME="gymhubtech-db"
DB_PASSWORD="@GymHubTech122025"

# --- Deploy to Cloud Run ---
# Note: Ensure the Docker image is already built and pushed to GCR before running this script
# Build: docker build -t "${IMAGE_NAME}" .
# Push: docker push "${IMAGE_NAME}"
echo "Deploying ${SERVICE_NAME} to Google Cloud Run in region ${REGION}..."

# Use gcloud function from bashrc (sourced above)
gcloud run deploy "${SERVICE_NAME}" \
  --image "${IMAGE_NAME}" \
  --platform managed \
  --region "${REGION}" \
  --allow-unauthenticated \
  --set-env-vars "APP_KEY=${APP_KEY},DB_CONNECTION=${DB_CONNECTION},DB_HOST=${DB_HOST},DB_DATABASE=${DB_DATABASE},DB_USERNAME=${DB_USERNAME},DB_PASSWORD=${DB_PASSWORD}" \
  --project "${PROJECT_ID}"

echo "Deployment complete for ${SERVICE_NAME}."
