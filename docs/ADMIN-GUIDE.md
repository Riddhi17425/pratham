# Pratham Admin Panel - Developer Guide

Laravel 12 admin panel. Login URL: `/admin/login`.

## 1. Flow
1. Guest opens any `/admin/*` URL -> redirected to `/admin/login`.
2. Login succeeds only if: correct credentials + `status = 1` + `role` is 1 or 2.
   After 5 wrong attempts the email+IP is locked for 60 seconds.
3. Dashboard (`/admin`) is the landing page.
4. Sidebar links lead to modules. Every module follows the same pattern (see section 4).
5. Sign out from the top-right menu.

## 2. Roles
| role | Name        | Access                                   |
|------|-------------|------------------------------------------|
| 1    | Super Admin | Everything, including Admin Users        |
| 2    | Admin       | Dashboard, Profile and all modules       |

Route protection: `->middleware('role:admin,super_admin')` and `->middleware('role:super_admin')`
(`app/Http/Middleware/RoleMiddleware.php`, alias registered in `bootstrap/app.php`).

## 3. Folder map
- `routes/web.php`                       all admin routes (add module routes at the marked comment)
- `app/Http/Controllers/Admin/`          one controller per module
- `app/Http/Middleware/RoleMiddleware`   role check
- `resources/views/admin/layouts/`       `master.blade.php` (page shell)
- `resources/views/admin/includes/`      headerUrl (CSS), sidebar, main-header, footer (JS), toast (messages)
- `resources/views/admin/<module>/`      index, create, edit, _form
- `public/js/admin-validate.js`          shared jQuery validation defaults

## 4. Adding a new module (checklist)
1. Migration + Model (use `SoftDeletes`, a `status` boolean).
2. `Admin/<Name>Controller` - copy the pattern of `UserController`
   (index+search, create/store, edit/update, updateStatus, destroy, restore, forceDelete).
3. Views in `resources/views/admin/<module>/` (index with Active/Trash tabs, create, edit, `_form`).
4. Routes in `routes/web.php` (resource + status + restore + force-delete).
5. Sidebar link in `includes/sidebar.blade.php`.
6. Validation on BOTH sides (section 5).
7. Messages via session keys `toast_success`, `toast_error`, `toast_info`. Keep all text in English.

## 5. Validation rules of this project
- **Server side (mandatory):** `$request->validate([...])` in the controller. This is the real security layer.
- **Client side (convenience):** jQuery Validation. Give the form an id + `novalidate`, then add
  `@push('scripts') <script>$('#formId').validate({...})</script> @endpush`.
  Defaults (red border, message placement, double-submit protection) live in `public/js/admin-validate.js`.
- Client rules and messages must mirror the server rules. English messages only.
- Passwords: minimum 8 characters, must be confirmed, stored hashed.

## 6. Conventions
- Destructive actions ask for confirmation.
- A user cannot delete or change the role/status of their own account.
- Deleting is soft first (Trash), permanent delete only from the Trash tab.
