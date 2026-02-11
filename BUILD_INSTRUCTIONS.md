# How to Build and Run the Customer Satisfaction Website

This project is containerized using Docker. Follow these steps to build, run, and push your image to Docker Hub.

## Prerequisites
- Docker Desktop installed and running.
- A Docker Hub account (if you plan to push the image).

## 1. Local Development (using Docker Compose)
To run the website locally for testing:

1. Open a terminal in this directory.
2. Run the following command:
   ```bash
   docker-compose up -d
   ```
3. Open your browser and navigate to `http://localhost:8080`.

## 2. Building for Docker Hub
To package the application for Docker Hub:

1. **Login to Docker Hub** via terminal:
   ```bash
   docker login
   ```

2. **Build the Image**:
   ```bash
   docker build -t fakerprime/customersatisfactionwebsite:latest .
   ```

3. **Push to Docker Hub**:
   ```bash
   docker push fakerprime/customersatisfactionwebsite:latest
   ```

## 3. Deployment on Tablet
Once the image is on Docker Hub, you can pull and run it on any device with Docker installed:

```bash
docker run -d -p 80:80 fakerprime/customersatisfactionwebsite:latest
```

## Tablet Optimization Features
- **Large Touch Targets**: Buttons and inputs are sized for touch interaction.
- **Responsive Layout**: Adapts to different tablet screen sizes (iPad, Android tablets).
- **Simplified Navigation**: Minimal distractions for users.
