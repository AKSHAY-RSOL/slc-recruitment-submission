<?php get_header(); ?>

<div class="container">
    <div class="search-bar">
        <input type="text" id="eventSearch" placeholder="Search events..." onkeyup="filterEvents()">
    </div>
    
    <div id="eventsContainer" class="grid">
        <div class="loading">Loading events...</div>
    </div>
</div>

<script>
let allEvents = [];

async function loadEvents() {
    try {
        const events = <?php echo json_encode(get_events()); ?>;
        
        if (events.error) {
            document.getElementById('eventsContainer').innerHTML = 
                '<div class="error">Error loading events: ' + events.error + '</div>';
            return;
        }
        
        allEvents = events;
        displayEvents(allEvents);
    } catch (error) {
        document.getElementById('eventsContainer').innerHTML = 
            '<div class="error">Error: ' + error.message + '</div>';
    }
}

function displayEvents(events) {
    const container = document.getElementById('eventsContainer');
    
    if (events.length === 0) {
        container.innerHTML = '<div class="loading">No events found</div>';
        return;
    }
    
    container.innerHTML = events.map(event => `
        <div class="card" onclick="window.open('https://clubs.iiit.ac.in/events/${event._id}', '_blank')">
            <h2>${event.name}</h2>
            <p><strong>Date:</strong> ${event.datetimeperiod || 'TBA'}</p>
            <p><strong>Location:</strong> ${event.location || 'TBA'}</p>
            <p><strong>Mode:</strong> ${event.mode || 'N/A'}</p>
            <div class="meta">
                <p>Club ID: ${event.clubid}</p>
            </div>
        </div>
    `).join('');
}

function filterEvents() {
    const searchTerm = document.getElementById('eventSearch').value.toLowerCase();
    const filtered = allEvents.filter(event => 
        event.name.toLowerCase().includes(searchTerm) ||
        (event.location && event.location.toLowerCase().includes(searchTerm)) ||
        (event.mode && event.mode.toLowerCase().includes(searchTerm))
    );
    displayEvents(filtered);
}

// Load events on page load
loadEvents();
</script>

<?php get_footer(); ?>
