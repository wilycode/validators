# Validators module instructions

Scope: `packages/validators` only.

## Responsibility

Reusable, infrastructure-independent validation rules built on `wilycode/validator`.

## Rules

- Depend on `wilycode/validator`, never on `wilycode/form`.
- Keep database/repository/domain checks in application validators, usually by extending `WilyCode\Validator\Validator`.
- Form-specific wrappers (field comparison, option-aware custom values) remain in `wilycode/form`.
- Update tests and README with behavior changes.
- PHP 8.4, strict types and 4-space indentation.
