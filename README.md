# SLC Tech Team Recruitment Task (UG2k25) - Submission

This repository contains the solutions for the SLC Recruitment Task.

## Directory Structure

*   **/taskA**: Contains the GraphQL Microservices solution (Task A).
    *   `services/`: Docker Compose and source code.
    *   `taskA_populate.py`: Script to populate the database with dummy data.
    *   `README.md`: Detailed instructions for Task A.
*   **/taskB**: Contains the WordPress Website solution (Task B).
    *   `wp-content/themes/slc-theme`: Custom WordPress theme.
    *   `docker-compose.yml`: WordPress hosting configuration.
    *   `README.md`: Detailed instructions for Task B.
*   **assumptions.md**: A list of assumptions made during the development.
*   **RUN_INSTRUCTIONS.md**: A quick guide to run everything from scratch.

## Quick Start

1.  **Task A**:
    ```bash
    cd taskA/services
    docker compose up -d --build
    # Then populate data:
    cd ../
    python taskA_populate.py
    ```

2.  **Task B**:
    ```bash
    cd taskB
    docker compose up -d
    # Configure WordPress and activate 'SLC Clubs Theme'
    ```

For troubleshooting and detailed verification steps, please refer to **RUN_INSTRUCTIONS.md**.
