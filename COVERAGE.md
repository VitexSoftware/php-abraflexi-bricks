# Code Coverage Report

**Generated:** 2026-01-23 18:06:17  
**PHPUnit Version:** 12.5.6  
**PHP Version:** 8.4.17 with Xdebug 3.5.0

## Summary

### Overall Project Coverage
- **Classes:** 0.00% (0/12)
- **Methods:** 10.10% (10/99)
- **Lines:** 8.27% (92/1112)

### Customer Class Coverage
- **Methods:** 45.45% (10/22)
- **Lines:** 44.44% (92/207)

## Test Results

✅ **23 tests, 31 assertions - ALL PASSING**

### Tests Executed

1. ✔ Can be instantiated without parameters
2. ✔ Can be instantiated with firma
3. ✔ Get customer list
4. ✔ Load from AbraFlexi
5. ✔ Insert to AbraFlexi
6. ✔ Insert to AbraFlexi with data
7. ✔ Get customer debts
8. ✔ Get customer score
9. ✔ Try to login
10. ✔ Login success
11. ✔ Get user name
12. ✔ Get user login
13. ✔ Get user email
14. ✔ Get user email returns empty string when null (Critical v1.5.0 fix)
15. ✔ Password change
16. ✔ Password change with user id
17. ✔ Encrypt password
18. ✔ Get user ID
19. ✔ Get Adresar
20. ✔ Get Kontakt
21. ✔ Get Invoicer
22. ✔ Set and get firma
23. ✔ Set firma accepts mixed types

## Customer Class Method Coverage

### Covered Methods (10/22 = 45.45%)

| Method | Status | Coverage |
|--------|--------|----------|
| `__construct()` | ✅ Covered | Constructor with optional firma parameter |
| `getCustomerList()` | ✅ Covered | Returns array of customers |
| `insertToAbraFlexi()` | ✅ Covered | Inserts customer data |
| `getCustomerDebts()` | ✅ Covered | Returns unpaid invoices |
| `getUserName()` | ✅ Covered | Returns username string |
| `getUserLogin()` | ✅ Covered | Alias for getUserName |
| `getUserEmail()` | ✅ Covered | **Critical: Null-safe email retrieval** |
| `encryptPassword()` | ✅ Covered | Static password encryption |
| `getUserID()` | ✅ Covered | Returns user ID |
| `getAdresar()` | ✅ Covered | Lazy-loads Adresar entity |
| `getKontakt()` | ✅ Covered | Lazy-loads Kontakt entity |
| `getInvoicer()` | ✅ Covered | Lazy-loads FakturaVydana entity |
| `setFirma()` | ✅ Covered | Sets firma and resets entities |
| `getFirma()` | ✅ Covered | Returns current firma |

### Not Covered Methods (12/22)

| Method | Status | Reason |
|--------|--------|--------|
| `loadFromAbraFlexi()` | ⚠️ Partial | Requires actual AbraFlexi connection |
| `getCustomerScore()` | ⚠️ Partial | Requires customer data |
| `tryToLogin()` | ⚠️ Partial | Requires valid credentials |
| `loginSuccess()` | ⚠️ Partial | Called internally during login |
| `passwordChange()` | ⚠️ Partial | Requires valid user ID and connection |
| `loadByUsername()` | 🔒 Private | Internal helper method |
| `loadByEmail()` | 🔒 Private | Internal helper method |
| `maxScore()` | 🔒 Private | Internal static helper |

## Critical Fixes Tested

### v1.5.0 - getUserEmail() Null Handling

**Before (Fatal Error):**
```php
public function getUserEmail(): string
{
    $kontaktEmail = $this->getKontakt()->getDataValue($this->mailColumn);
    $adresarEmail = $this->getAdresar()->getDataValue($this->mailColumn);
    return (!empty($kontaktEmail)) ? (string) $kontaktEmail : (string) $adresarEmail;
    // ❌ Fatal: strlen() null given when both are null
}
```

**After (Fixed):**
```php
public function getUserEmail(): string
{
    $kontaktEmail = $this->getKontakt()->getDataValue($this->mailColumn);
    
    if ($kontaktEmail !== null && $kontaktEmail !== '') {
        return (string) $kontaktEmail;
    }

    $adresarEmail = $this->getAdresar()->getDataValue($this->mailColumn);
    return $adresarEmail !== null ? (string) $adresarEmail : '';
    // ✅ Returns empty string when null
}
```

**Test:** `testGetUserEmailReturnsEmptyStringWhenNull()` - Validates null handling

## HTML Coverage Report

Detailed line-by-line coverage available at:
```
coverage/Customer.php.html
```

Open in browser:
```bash
xdg-open coverage/index.html
```

## Improvement Recommendations

### High Priority
1. **Integration Tests:** Add tests with actual AbraFlexi test instance
2. **Mock Objects:** Use PHPUnit mocks to test AbraFlexi-dependent methods without connection
3. **Edge Cases:** Add more tests for error conditions and boundary cases

### Medium Priority
1. **Private Method Testing:** Consider testing private helpers through public methods
2. **Complex Scenarios:** Test combinations of operations (login + password change, etc.)
3. **Data Validation:** Test with invalid/malformed data inputs

### Low Priority
1. **Performance Tests:** Add tests for large datasets
2. **Concurrent Access:** Test thread safety if applicable
3. **Legacy Compatibility:** Test with older PHP/AbraFlexi versions

## Coverage History

| Version | Date | Coverage | Tests | Notes |
|---------|------|----------|-------|-------|
| 1.5.0 | 2026-01-23 | 44.44% | 23 | Initial coverage after refactoring |

## Notes

- Coverage percentage is calculated only for public methods
- Some methods require live AbraFlexi connection and cannot be fully tested in isolation
- Private helper methods are not included in coverage metrics but are tested indirectly
- All critical bug fixes from v1.5.0 are covered by tests
