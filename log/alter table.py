import sqlite3
import ipaddress

# Connect to SQLite database
conn = sqlite3.connect('geoloc.sqlite')  # Replace with your SQLite database file
cursor = conn.cursor()

# Step 1: Add new columns for range_start and range_end
cursor.execute("ALTER TABLE ipv4 ADD COLUMN range_start TEXT")
cursor.execute("ALTER TABLE ipv4 ADD COLUMN range_end TEXT")

# Step 2: Fetch all rows from the table
cursor.execute("SELECT network, rowid FROM ipv4")
rows = cursor.fetchall()

# Step 3: Update range_start and range_end based on the network column
for row in rows:
    network = row[0]  # CIDR format, e.g., "1.0.2.0/23"
    row_id = row[1]   # Row ID to identify the record
    if network:
        # Parse the CIDR to get start and end IP addresses
        ip_net = ipaddress.ip_network(network, strict=False)
        range_start = str(ip_net.network_address)  # First IP in the range
        range_end = str(ip_net.broadcast_address)  # Last IP in the range

        # Update the record with calculated values
        cursor.execute(
            "UPDATE ipv4 SET range_start = ?, range_end = ? WHERE rowid = ?",
            (range_start, range_end, row_id)
        )

# Commit changes and close the connection
conn.commit()
conn.close()

print("Table updated with range_start and range_end columns.")
