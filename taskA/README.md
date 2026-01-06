## Note on the `services` Directory

The `services` directory was **previously configured as a Git submodule** pointing to the Clubs Council services repository:  
https://github.com/Clubs-Council-IIITH/services

To ensure smoother development and avoid submodule-related issues, it has now been **converted into a normal directory** within this repository.

### What Changed?
- The submodule reference was removed.
- Several internal files and configurations were modified so that `services/` works as a **standalone, regular folder**.
- Due to this transition, **multiple changes** were necessary and may appear extensive in the commit history.

### Important Note for Reviewers & Contributors
If you face **any issues while running the project locally on your system**, please feel free to reach out.  
I’m happy to **run the project locally and demonstrate the working setup** to clarify any confusion caused by the submodule-to-folder migration.


Thanks for your understanding! 
