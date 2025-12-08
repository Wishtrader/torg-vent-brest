import ftplib
import sys

host = "178.172.244.107"
user = "domen11"
password = "@654321@"

print(f"Connecting to {host} as {user}...")

try:
    ftp = ftplib.FTP(host)
    ftp.login(user, password)
    print("Login successful!")
    
    print("Listing root directory:")
    ftp.retrlines('LIST')
    
    target_dir = "/wp-content/themes/bdv"
    print(f"\nChanging to {target_dir}...")
    try:
        ftp.cwd(target_dir)
        print(f"Changed directory to {target_dir}")
        print("Listing target directory:")
        ftp.retrlines('LIST')
    except Exception as e:
        print(f"Could not change to {target_dir}: {e}")
        
    ftp.quit()
except Exception as e:
    print(f"Error: {e}")
    sys.exit(1)
