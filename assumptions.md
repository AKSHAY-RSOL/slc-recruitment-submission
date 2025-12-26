# Assumptions Made During Implementation

## General Assumptions

1. **Docker Installation**: Assumed Docker Desktop would be installed by the user before running the tasks. Provided configuration files ready to use once Docker is available.

2. **Network Connectivity**: Assumed IIIT network access is not available during development, so focused on local setup instructions.

3. **GraphQL Endpoint**: For Task B, assumed the GraphQL endpoint from Task A would be available at `http://host.docker.internal/graphql`. Provided fallback to production endpoint `https://clubs.iiit.ac.in/graphql`.

## Task A Assumptions

1. **Submodule Access**: Assumed public submodules (gateway, clubs, events, users, members, interfaces) are accessible via HTTPS. Private repos (auth, files) were commented out as instructed.

2. **Authentication Bypass**: Planned to modify resolver code in subgraphs to bypass authentication checks. Exact implementation depends on how auth is currently implemented (likely via decorators or middleware).

3. **Database Initialization**: Assumed MongoDB will start empty. Would need to manually create clubs/members/events via GraphQL mutations.

4. **Port Availability**: Assumed port 80 (nginx), 27017 (MongoDB) are available on the host system.

## Task B Assumptions

1. **WordPress Version**: Used latest WordPress Docker image (currently 6.x). Theme is compatible with WordPress 5.0+.

2. **PHP Version**: Assumed PHP 7.4+ with `file_get_contents()` and `json_decode()` available for GraphQL queries.

3. **Theme Activation**: Assumed user can access WordPress admin panel to activate the custom theme and configure permalinks.

4. **GraphQL Schema**: Assumed the GraphQL schema matches the production schema at `https://clubs.iiit.ac.in/graphql`:
   - `activeClubs` query returns: `cid`, `name`, `category`
   - `events` query returns: `_id`, `name`, `clubid`, `datetimeperiod`, `location`, `mode`

5. **Data Availability**: If Task A is not completed, assumed production GraphQL endpoint can be used as fallback.

6. **Browser Compatibility**: Assumed modern browsers (Chrome, Firefox, Edge) with JavaScript enabled.

## Design Assumptions

1. **UI/UX**: Assumed modern, visually appealing design is preferred over minimal MVP based on problem statement emphasis on "simple" website.

2. **Search Functionality**: Implemented client-side search for instant filtering. Assumed this is acceptable over server-side search.

3. **Responsive Design**: Assumed mobile compatibility is important even though not explicitly mentioned.

4. **External Links**: Assumed clicking on clubs/events should open the official clubs website for full details.

## Technical Assumptions

1. **No Authentication**: Assumed WordPress site doesn't need user authentication (public-facing only).

2. **No Database Caching**: Assumed fresh data fetch on each page load is acceptable for this demo.

3. **Error Handling**: Implemented basic error messages. Assumed detailed error logging is not required for this task.

4. **CORS**: Assumed GraphQL endpoint allows cross-origin requests from WordPress container.

## Submission Assumptions

1. **Repository Structure**: Followed the suggested structure with separate `taskA` and `taskB` directories.

2. **Documentation**: Assumed detailed README files for each task are preferred over a single combined document.

3. **Screenshots**: Assumed screenshots will be taken after Docker is installed and services are running.

4. **Code Comments**: Assumed inline comments in code are sufficient; no separate code documentation required.

5. **Git History**: Assumed clean, organized commits are not required for submission (single push is acceptable).
