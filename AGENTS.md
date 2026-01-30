# AGENTS.md

This document provides guidelines and commands for agentic coding agents working on the dcat-admin codebase.

## Project Overview

This is a fork of dcat-admin, a Laravel admin panel building tool. It's a PHP library that provides a complete admin interface framework with support for:
- Grid tables with filtering, sorting, and pagination
- Form builders with various field types
- Tree structures
- User management and RBAC
- Extensible plugin system

## Commands

### PHP/Laravel Commands
```bash
# Install dependencies
composer install

# Run PHPStan static analysis
composer phpstan
# or
vendor/bin/phpstan analyse

# Run PHPUnit tests
composer test
# or
vendor/bin/phpunit

# Run single test file
vendor/bin/phpunit tests/Feature/SectionTest.php

# Run tests with specific group
vendor/bin/phpunit --group section

# Install dcat admin (for testing)
php artisan admin:install
php artisan admin:publish
```

### Frontend/Asset Commands
```bash
# Install npm dependencies
npm install

# Development build
npm run dev
npm run development

# Watch for changes
npm run watch

# Production build
npm run prod
npm run production

# Hot reloading
npm run hot

# Watch with polling (for Docker environments)
npm run watch-poll
```

## Code Style Guidelines

### PHP Code Style

#### Namespaces
- All classes under `src/` use `Dcat\Admin` as the root namespace
- Follow PSR-4 autoloading structure
- Sub-namespaces reflect directory structure: `Dcat\Admin\Grid\Actions`, `Dcat\Admin\Form\Field`, etc.

#### Class Naming
- Use PascalCase for class names
- Abstract classes should be prefixed with `Abstract` (e.g., `AbstractField`)
- Trait names should use PascalCase and describe the functionality
- Interfaces should be descriptive and may include suffixes like `Interface` or `Contract`

#### Method Naming
- Use camelCase for method names
- Boolean methods should start with `is`, `has`, `can`, etc.
- Getter methods: `getPropertyName()` or just `propertyName()`
- Setter methods: `setPropertyName($value)`

#### Properties
- Use camelCase for property names
- Use visibility keywords (private, protected, public)
- Document complex properties with PHPDoc

#### Imports
- Use fully qualified imports at the top of files
- Group imports: external libraries first, then internal framework imports, then project imports
- Remove unused imports

### Code Structure

#### Traits
- Use traits for shared functionality across classes
- Common traits include: `HasAuthorization`, `HasAssets`, `HasDateTimeFormatter`
- Keep traits focused on specific concerns

#### Abstract Classes
- Use abstract classes for base implementations
- Provide common functionality that concrete classes can extend
- Define abstract methods that must be implemented

#### Forms and Fields
- Form fields extend `Dcat\Admin\Form\Field`
- Use traits like `PlainInput`, `Sizeable` for common field functionality
- Field classes should be in `src/Form/Field/`

#### Grid Components
- Grid classes in `src/Grid/` namespace
- Actions in `src/Grid/Actions/`
- Displayers in `src/Grid/Displayers/`
- Filters in `src/Grid/Filter/`

### Error Handling

#### Exceptions
- Use specific exception types when available
- Custom exceptions should extend appropriate base exceptions
- Include meaningful error messages
- Use proper HTTP status codes for web responses

#### Validation
- Validate inputs at the appropriate layer
- Use Laravel's validation rules when possible
- Provide clear validation error messages

### Documentation

#### PHPDoc
- Document all public methods and properties
- Include parameter types and return types
- Use `@param`, `@return`, `@throws` tags appropriately
- Document complex logic or business rules

#### Comments
- Add comments for complex business logic
- Explain "why" not "what"
- Avoid obvious comments

### Testing

#### Test Structure
- Unit tests in `tests/Unit/`
- Feature tests in `tests/Feature/`
- Browser tests in `tests/Browser/`
- Test classes should end with `Test.php`

#### Test Naming
- Use descriptive test method names
- Test methods should describe what is being tested and the expected result
- Use `@group` annotations for organizing tests

#### Best Practices
- Write tests for new functionality
- Test both positive and negative cases
- Use factories for test data when available
- Clean up after tests that modify the database

### Frontend Development

#### JavaScript
- Use ES6+ syntax
- Follow existing patterns in `resources/assets/dcat/js/`
- Component-based architecture where applicable
- Use consistent naming conventions

#### SCSS/CSS
- Use SCSS for styling
- Follow existing patterns in `resources/assets/dcat/sass/`
- Use meaningful class names
- Responsive design considerations

## Development Workflow

### Before Making Changes
1. Run existing tests to ensure baseline
2. Check for any existing issues or TODOs
3. Understand the existing code patterns in the relevant area

### After Making Changes
1. Run tests: `vendor/bin/phpunit`
2. Run static analysis: `vendor/bin/phpstan analyse`
3. Test frontend build: `npm run dev` if assets changed
4. Update documentation if needed

### Submitting Changes
1. Follow PSR-12 coding standards
2. Ensure all tests pass
3. Add tests for new functionality
4. Update relevant documentation
5. Consider backward compatibility

## Important Notes

- This is a library, maintain backward compatibility when possible
- Support PHP 8.1+ and Laravel 10, 11, 12
- Database migrations should be reversible
- Asset compilation is required for frontend changes
- Follow Laravel conventions and best practices
- Use dependency injection and service container appropriately