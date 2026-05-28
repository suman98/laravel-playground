Create a new page called `vocab/slides` with the following features:

- Retrieve all words from `app/Models/UnknownWord.php`.
- Display each word individually, one per slide.
- Pronunciation of the word automatically when shown in slide.
- At the bottom of each slide, include two buttons: "Familiar" and "Unfamiliar".
    - When the user clicks "Familiar":
        - Send a [PATCH] request to `/api/unknown-words/familiar`.
        - This request should update the `is_familiar` boolean field in `app/Models/UnknownWord.php` for the respective word.
    - When the user clicks "Unfamiliar":
        - Send a [PATCH] request to `/api/unknown-words/unfamiliar`.
        - This should set the `is_familiar` boolean value to false for that word.
- After clicking either button, display the full details (e.g., meaning, sentence, Nepali equivalent, etc.) of the word to the user.
- Include a "Reset All" button that sets the `is_familiar` field to false for all words.
- Add next/previous button 

Note: The `unknown_words` table currently does not have an `is_familiar` column; you will need to create a migration to add this field.