# About LaraViewModel

LaraViewModel enhances Laravel, a web application customized by myself. In the ViewModel layer, you have the flexibility to perform common tasks within the application. What sets this project apart from vanilla Laravel is the integration of the ViewModel section after the controller. With LaraViewModel, you can seamlessly return both API responses and views.

The ViewModels are conveniently located in the ViewModels folder within the modules.

### Features:

- **Theme Configuration:** Set the theme (for admin or normal users) in the `__construct` function.

- **Grid Data Presentation:** Use the `setGridData` function to display a table of information to the user.

- **Dynamic Columns Configuration:** Tailor column settings in the `setColumns` function based on the table's name.

- **Grid Display:** Utilize the `showGrid` function to return both the view and the configured columns.

- **File Upload:** Easily save files to storage with the `uploadFile` function.

Enhance your Laravel experience with LaraViewModel, streamlining your development process and offering extended functionalities. Feel free to explore the ViewModels folder inside modules for organized and efficient project management.
