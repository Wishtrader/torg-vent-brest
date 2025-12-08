import ftplib
import os
import sys

host = "178.172.244.107"
user = "domen11"
password = "@654321@"
remote_dir = "/wp-content/themes/bdv"
local_dir = "/Users/andreikamarou/.gemini/antigravity/scratch/bdv_theme"

def download_files(ftp, remote_path, local_path):
    print(f"Entering {remote_path}...")
    try:
        ftp.cwd(remote_path)
        # Get list of files/dirs
        try:
            filenames = ftp.nlst()
        except ftplib.error_perm as e:
            # Empty directory or permission error
            print(f"Could not list {remote_path}: {e}")
            return

        if not os.path.exists(local_path):
            os.makedirs(local_path)
            
        for filename in filenames:
            if filename in ['.', '..']:
                continue
                
            # Ensure we are in the correct directory for this level
            ftp.cwd(remote_path)
            
            local_file_path = os.path.join(local_path, filename)
            remote_file_path = f"{remote_path}/{filename}"
            
            is_directory = False
            try:
                # Try to change into the file as if it were a directory
                ftp.cwd(filename)
                is_directory = True
                # Go back to parent
                ftp.cwd('..')
            except ftplib.error_perm:
                is_directory = False
            
            if is_directory:
                download_files(ftp, remote_file_path, local_file_path)
            else:
                print(f"Downloading {filename} to {local_file_path}...")
                try:
                    with open(local_file_path, 'wb') as f:
                        ftp.retrbinary('RETR ' + filename, f.write)
                except Exception as e:
                    print(f"Failed to download {filename}: {e}")
                    
    except ftplib.error_perm as e:
        print(f"Error accessing {remote_path}: {e}")

print(f"Connecting to {host}...")
try:
    ftp = ftplib.FTP(host)
    ftp.login(user, password)
    
    print(f"Starting download from {remote_dir} to {local_dir}...")
    download_files(ftp, remote_dir, local_dir)
    
    ftp.quit()
    print("Download complete!")
except Exception as e:
    print(f"Error: {e}")
    sys.exit(1)
