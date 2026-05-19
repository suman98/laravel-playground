Design and implement a new API endpoint for storing unknown words.

Endpoint:
[POST] api/save_unknown_words


Payload Example:
{
    "word": "string",         // Required
    "meaning": "string",      // Required
    "sentence": "string",     // Required
    "np_word": "string"       // Optional (Nepali equivalent or related word)
}

Field Requirements:
- "word": required, string
- "meaning": required, string
- "sentence": required, string
- "np_word": optional, string

Successful Response (HTTP 200):
{
    "data": {
        "word": {
            "id": "integer or string (auto-generated)",
            "word": "string",
            "meaning": "string",
            "sentence": "string",
            "np_word": "string or null"
        }
    }
}

Additionally, implement full CRUD (Create, Read, Update, Delete) operations for unknown words.
- Set up the necessary database migration for persistence, including appropriate fields and types.
- Ensure endpoints for retrieving, updating, and deleting unknown words are created following RESTful conventions.

