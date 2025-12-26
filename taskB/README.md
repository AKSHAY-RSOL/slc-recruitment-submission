# Task B: WordPress Website - Setup Guide

## Overview
This task creates a simple WordPress website with two main pages:
- `/clubs` - Displays a dynamic list of clubs fetched from the GraphQL backend
- `/events` - Displays a dynamic list of events fetched from the GraphQL backend

Both pages include **search functionality** (Bonus feature implemented).

## Prerequisites
- Docker and Docker Compose installed
- Task A GraphQL backend running at `http://localhost/graphql`

## Directory Structure
```
taskB/
├── docker-compose.yml          # WordPress + MySQL setup
├── php-config.ini              # PHP configuration
└── wp-content/
    └── themes/
        └── slc-theme/          # Custom theme
            ├── style.css       # Theme styling
            ├── functions.php   # GraphQL integration
            ├── header.php      # Header template
            ├── footer.php      # Footer template
            ├── index.php       # Home page
            ├── page-clubs.php  # Clubs page
            └── page-events.php # Events page
```

## Setup Instructions

### Step 1: Start WordPress
```bash
cd taskB
docker compose up -d
```

### Step 2: Initial WordPress Setup
1. Open browser and navigate to `http://localhost:8080`
2. Complete WordPress installation:
   - Choose language
   - Set site title: "SLC Clubs Portal"
   - Set username and password
   - Click "Install WordPress"

### Step 3: Activate Custom Theme
1. Log in to WordPress admin (`http://localhost:8080/wp-admin`)
2. Go to **Appearance > Themes**
3. Activate **SLC Clubs Theme**

### Step 4: Configure Permalinks
1. Go to **Settings > Permalinks**
2. Select **Post name** or **Custom Structure**: `/%postname%/`
3. Click **Save Changes**
4. Go to **Settings > Permalinks** again and click **Save Changes** (this flushes rewrite rules)

## Usage

### Accessing Pages
- **Home**: `http://localhost:8080/`
- **Clubs**: `http://localhost:8080/clubs`
- **Events**: `http://localhost:8080/events`

### Features

#### 1. Dynamic Data Fetching
- Data is fetched from GraphQL endpoint: `http://host.docker.internal/graphql`
- Uses public queries (no authentication required)
- Falls back to production endpoint if local is unavailable

#### 2. Search Functionality (Bonus)
Both `/clubs` and `/events` pages include a search bar that filters results in real-time based on:
- **Clubs**: Name, Category
- **Events**: Name, Location, Mode

#### 3. Click to View Details
Clicking on any club or event card opens the full details on the official clubs website.

## GraphQL Queries Used

### Clubs Query
```graphql
query ActiveClubs {
  activeClubs {
    cid
    name
    category
  }
}
```

### Events Query
```graphql
query Events($limit: Int) {
  events(limit: $limit) {
    _id
    name
    clubid
    datetimeperiod
    location
    mode
  }
}
```

## Design Features
- **Modern UI**: Gradient backgrounds, card-based layout
- **Responsive**: Works on all screen sizes
- **Smooth Animations**: Hover effects, transitions
- **Glassmorphism**: Modern design aesthetic
- **Clean Typography**: Professional fonts

## Troubleshooting

### Issue: "Error loading clubs/events"
**Solution**: Ensure Task A GraphQL backend is running at `http://localhost/graphql`

### Issue: Pages show 404
**Solution**: 
1. Go to WordPress Admin > Settings > Permalinks
2. Click "Save Changes" to flush rewrite rules
3. Try accessing the pages again

### Issue: Can't connect to GraphQL from WordPress
**Solution**: 
- Check if both Docker networks can communicate
- Verify `host.docker.internal` resolves correctly
- Alternative: Use production endpoint `https://clubs.iiit.ac.in/graphql`

## Alternative: Using Production GraphQL Endpoint

If you couldn't complete Task A, you can modify `functions.php` to use the production endpoint:

```php
define('GRAPHQL_ENDPOINT', 'https://clubs.iiit.ac.in/graphql');
```

This will fetch real data from the live clubs website.

## Screenshots

Screenshots should show:
1. Home page with navigation
2. Clubs page with search functionality
3. Events page with filtered results
4. Responsive design on different screen sizes

## Notes
- Theme uses vanilla PHP (no external dependencies)
- Search is client-side (JavaScript) for instant filtering
- All styling is custom CSS (no frameworks)
- Compatible with WordPress 5.0+
