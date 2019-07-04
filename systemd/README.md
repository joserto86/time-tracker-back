# Systemd

Esta configuración de timer esta pensado para sistemas con docker.

# Timers

Configuración de procesos que se tienen que ejecutar cada x tiempo, para el correcto funcionamiento de la aplicación.

## Systemd

/etc/systemd/system/

````bash

chmod +x {service}.[service|timer]

systemctl daemon-reload

systemctl enable {service}.[service|timer]
systemctl status {service}.[service|timer]
systemctl start  {service}.[service|timer]

systemctl disable {service}.[service|timer]
````

