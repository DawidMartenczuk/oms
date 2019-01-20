# Order Management System

System zamówień prezentujący umiejętności integracji z systemem magazynowym Asseco WAPRO Mag, API firmy logistycznej GLS ADE PLUS, a także biegłość w implementacji projektów używając frameworku Laravel.


### Integracja z WAPRO Mag
<img align="center" src="https://logos-net.pl/wp-content/uploads/2013/12/logo_wapro400x200.png" />

Integracja z WAPRO Mag odbywa się przez wykorzystanie ORM, dostarczonego we frameworku Laravel, jakim jest Eloquent. Dzięki zmapowaniu encji Mag na modele Eloquent jesteśmy w stanie używać w pełni właściwości dostarczanych przez framework w obrębie tych obiektów.

Procedury potrzebne do pracy systemu zostały zaimplementowane wewnątrz modeli jako metody statyczne.

### Integracja z GLS (SOAP)
<img align="center" src="https://gls-group.eu/PL/media/images/ADE-Plus-logo-20371_Table.png" />

Do integracji GLS SOAP wykonałem niewielki interfejs do obsługi zewnętrznego API, prezentując umiejętności implementacji obsługi interfejsów programistycznych SOAP WSDL.

### Obiekty lokalne Laravel

Do prawidłowej obsługi sklepu postanowiłem zaimplementować kilka lokalnych obiektów, takich jak podstawowe modele wchodzące w skład modułu autoryzacyjnego Laravel, a także modele do obsługi API GLS.
