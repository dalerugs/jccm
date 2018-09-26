title JCCM Management System
START c:/xampp/xampp-control.exe
netsh wlan set hostednetwork mode=allow ssid=jccm key=password keyUsage=persistent
netsh wlan start hostednetwork
for /f "tokens=14" %%a in ('ipconfig ^| findstr IPv4') do set _IPaddr=%%a
start "" http://%_IPaddr%
