import httpx
import asyncio
import json

GRAPHQL_URL = "http://localhost/graphql"

async def run_mutation(name, query, variables=None):
    async with httpx.AsyncClient(timeout=30.0) as client:
        response = await client.post(
            GRAPHQL_URL,
            json={"query": query, "variables": variables or {}}
        )
        data = response.json()
        if "errors" in data:
            print(f"FAILURE in {name}: {json.dumps(data['errors'], indent=2)}")
        else:
            print(f"SUCCESS in {name}")
        return data

async def populate():
    # 1. Create 3 Clubs
    clubs = [
        {"cid": "hacking", "name": "Hacking Club", "code": "HACKING", "category": "technical", "email": "hacking@iiit.ac.in", "description": "Ethical Hacking and Security"},
        {"cid": "robotics", "name": "Robotics Club", "code": "ROBOTICS", "category": "technical", "email": "robotics@iiit.ac.in", "description": "Building the future"},
        {"cid": "music", "name": "Music Club", "code": "MUSIC", "category": "cultural", "email": "music@iiit.ac.in", "description": "Melodies of IIIT"}
    ]
    
    for c in clubs:
        mutation = """
        mutation CreateClub($clubInput: FullClubInput!) {
          createClub(clubInput: $clubInput) {
            cid
            name
          }
        }
        """
        variables = {
            "clubInput": {
                "cid": c["cid"],
                "name": c["name"],
                "code": c["code"],
                "category": c["category"],
                "email": c["email"],
                "tagline": f"Welcome to {c['name']}",
                "description": c["description"],
                "socials": {
                    "website": "https://iiit.ac.in",
                    "otherLinks": []
                }
            }
        }
        await run_mutation(f"CreateClub({c['cid']})", mutation, variables)

    # 2. Add 3 Members per Club
    for c in clubs:
        for i in range(1, 4):
            uid = f"user_{c['cid']}_{i}"
            mutation = """
            mutation CreateMember($memberInput: FullMemberInput!) {
              createMember(memberInput: $memberInput) {
                uid
                cid
              }
            }
            """
            variables = {
                "memberInput": {
                    "cid": c["cid"],
                    "uid": uid,
                    "roles": [{
                        "name": "Member", 
                        "startYear": 2023,
                        "endYear": None
                    }],
                    "poc": i == 1
                }
            }
            await run_mutation(f"CreateMember({uid})", mutation, variables)

    # 3. Create 2 Events per Club
    for c in clubs:
        for i in range(1, 3):
            event_name = f"{c['name']} Event {i}"
            mutation = """
            mutation CreateEvent($details: InputEventDetails!) {
              createEvent(details: $details) {
                code
                name
              }
            }
            """
            # Start time: 2 days from now, End time: 2 days + 2 hours
            # Strawberry expects "YYYY-MM-DDTHH:MM:SS" for DateTime
            start = "2025-01-01T10:00:00"
            end = "2025-01-01T12:00:00"
            variables = {
                "details": {
                    "name": event_name,
                    "clubid": c["cid"],
                    "datetimeperiod": [start, end],
                    "poc": f"user_{c['cid']}_1",
                    "description": f"Amazing event by {c['name']}",
                    "mode": "offline",
                    "location": ["h101"],
                    "audience": ["internal", "ug1", "ug2"],
                    "population": 50,
                    "externalPopulation": 0,
                    "budget": [],
                    "sponsor": [],
                    "collabclubs": []
                }
            }
            await run_mutation(f"CreateEvent({event_name})", mutation, variables)

if __name__ == "__main__":
    asyncio.run(populate())
