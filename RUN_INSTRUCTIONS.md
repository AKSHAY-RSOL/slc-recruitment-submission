# Run Instructions for SLC Tech Team Recruitment Task

Follow these steps to run the entire project locally on your Windows machine.

## Prerequisites

1.  **Docker Desktop**: Ensure Docker Desktop is installed and running.
    *   You should see the Docker whale icon in your system tray.
    *   Verify by running `docker --version` in PowerShell.

## Task A: GraphQL Microservices

This task sets up the backend services.

### 1. START the Services
Open a PowerShell terminal and run:

```powershell
cd "c:\Users\user\Desktop\SEM 2\SLC\taskA\services"
docker compose up -d --build
```

*   `cd` navigates to the directory.
*   `docker compose up -d --build` builds the images and starts the containers in detached mode (background).
*   **Wait**: This may take a few minutes the first time.

### 2. VERIFY Services are Running
Run:

```powershell
docker compose ps
```

You should see all services (`mongo`, `gateway`, `clubs`, etc.) with status `Up`.

### 3. POPULATE with Data
Once the services are up, populate the database with the test data (Clubs, Members, Events).
Run this from the root directory (`c:\Users\user\Desktop\SEM 2\SLC`):

```powershell
cd "c:\Users\user\Desktop\SEM 2\SLC"
python taskA_populate.py
```

*   You should see `SUCCESS` messages for creating clubs, members, and events.
*   If you see errors, ensure the services are fully up (wait 10-20 seconds after step 1).

### 4. CHECK GraphQL Playground
Open your browser and go to:
[http://localhost/graphql](http://localhost/graphql)

You can run a test query there:
```graphql
query {
  allClubs(onlyActive: true) {
    name
    email
  }
}
```

---

## Task B: WordPress Website

This task sets up the frontend website.

### 1. START WordPress
Open a **new** PowerShell terminal (or reuse the existing one):

```powershell
cd "c:\Users\user\Desktop\SEM 2\SLC\taskB"
docker compose up -d
```

### 2. SETUP WordPress
1.  Open your browser to: [http://localhost:8080](http://localhost:8080)
2.  Select **English** -> Continue.
3.  Fill in the "Information needed":
    *   **Site Title**: SLC Clubs
    *   **Username**: admin
    *   **Password**: [choose a password]
    *   **Email**: [your email]
4.  Click **Install WordPress**.
5.  **Log In** with your new credentials.

### 3. ACTIVATE Theme
1.  Go to the WordPress Dashboard ([http://localhost:8080/wp-admin](http://localhost:8080/wp-admin)).
2.  Navigate to **Appearance** > **Themes**.
3.  You will see "SLC Clubs Theme" (or similar). Click **Activate**.

### 4. CONFIGURE Permalinks (Crucial!)
1.  Navigate to **Settings** > **Permalinks**.
2.  Select **Post name** (or Custom Structure: `/%postname%/`).
3.  Click **Save Changes**.
4.  **Click "Save Changes" AGAIN**. (This flushes the rewrite rules to enable `/clubs` and `/events`).

### 5. VERIFY The Site
Visit the pages:
*   **Clubs**: [http://localhost:8080/clubs](http://localhost:8080/clubs)
*   **Events**: [http://localhost:8080/events](http://localhost:8080/events)
*   **Home**: [http://localhost:8080/](http://localhost:8080/)

---

## Troubleshooting

### "Error loading clubs" on WordPress
*   Ensure Task A is running (`docker ps`).
*   The WordPress container tries to connect to `http://host.docker.internal/graphql`. This usually works out-of-the-box on Docker Desktop for Windows.
*   If it fails, you can edit `taskB/wp-content/themes/slc-theme/functions.php` and uncomment the production endpoint line to test.

### "Not Authenticated" in Task A
*   We have already patched the code to bypass auth. If you still see this, ensure you rebuilt the images:
    ```powershell
    cd "c:\Users\user\Desktop\SEM 2\SLC\taskA\services"
    docker compose up -d --build
    ```

### Docker Ports in Use
*   If ports 80 or 8080 are taken, edit the `docker-compose.yml` files to map to different ports (e.g., `8081:80`).
