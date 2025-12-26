<?php get_header(); ?>

<div class="container">
    <div style="background: white; border-radius: 15px; padding: 40px; margin: 40px auto; max-width: 800px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
        <h2 style="color: #667eea; text-align: center; margin-bottom: 30px;">Welcome to SLC Clubs Portal</h2>
        
        <div style="text-align: center; margin: 30px 0;">
            <p style="font-size: 1.2em; color: #666; margin-bottom: 30px;">
                Explore student clubs and upcoming events at IIIT Hyderabad
            </p>
            
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="/clubs" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: transform 0.3s; display: inline-block;">
                    Browse Clubs
                </a>
                <a href="/events" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: transform 0.3s; display: inline-block;">
                    View Events
                </a>
            </div>
        </div>
        
        <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #eee;">
            <h3 style="color: #667eea; margin-bottom: 15px;">Features:</h3>
            <ul style="color: #666; line-height: 2;">
                <li>✨ Dynamic club listings from GraphQL backend</li>
                <li>📅 Real-time event information</li>
                <li>🔍 Search functionality for clubs and events</li>
                <li>🎨 Modern, responsive design</li>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>
