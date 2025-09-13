# Storage Setup Instructions

To enable profile picture uploads to work correctly, you need to create a symbolic link from the public storage to the storage directory.

## Run this command in your Laravel project directory:

```bash
php artisan storage:link
```

This command creates a symbolic link from `public/storage` to `storage/app/public`, allowing publicly accessible files to be served from the storage directory.

## Alternative (if the command doesn't work):

You can manually create the storage directory structure:

1. Create the directory: `storage/app/public/profile-pictures`
2. Ensure the `public/storage` symbolic link exists and points to `storage/app/public`

## Note:
The profile pictures will be stored in `storage/app/public/profile-pictures/` and accessible via `/storage/profile-pictures/` URL.