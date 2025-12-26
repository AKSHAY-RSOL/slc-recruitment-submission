<?php get_header(); ?>

<div class="container">
    <div class="search-bar">
        <input type="text" id="clubSearch" placeholder="Search clubs..." onkeyup="filterClubs()">
    </div>
    
    <div id="clubsContainer" class="grid">
        <div class="loading">Loading clubs...</div>
    </div>
</div>

<script>
let allClubs = [];

async function loadClubs() {
    try {
        const clubs = <?php echo json_encode(get_clubs()); ?>;
        
        if (clubs.error) {
            document.getElementById('clubsContainer').innerHTML = 
                '<div class="error">Error loading clubs: ' + clubs.error + '</div>';
            return;
        }
        
        allClubs = clubs;
        displayClubs(allClubs);
    } catch (error) {
        document.getElementById('clubsContainer').innerHTML = 
            '<div class="error">Error: ' + error.message + '</div>';
    }
}

function displayClubs(clubs) {
    const container = document.getElementById('clubsContainer');
    
    if (clubs.length === 0) {
        container.innerHTML = '<div class="loading">No clubs found</div>';
        return;
    }
    
    container.innerHTML = clubs.map(club => `
        <div class="card" onclick="window.open('https://clubs.iiit.ac.in/clubs/${club.cid}', '_blank')">
            <h2>${club.name}</h2>
            <p><strong>Category:</strong> ${club.category || 'N/A'}</p>
            <div class="meta">
                <p>Club ID: ${club.cid}</p>
            </div>
        </div>
    `).join('');
}

function filterClubs() {
    const searchTerm = document.getElementById('clubSearch').value.toLowerCase();
    const filtered = allClubs.filter(club => 
        club.name.toLowerCase().includes(searchTerm) ||
        (club.category && club.category.toLowerCase().includes(searchTerm))
    );
    displayClubs(filtered);
}

// Load clubs on page load
loadClubs();
</script>

<?php get_footer(); ?>
