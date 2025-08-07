from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.action_chains import ActionChains
import time
import time

def test_register(driver, base_url):
    driver.get(f"{base_url}/register")

    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.ID, "name-input"))
    ).send_keys("Test User")

    driver.find_element(By.ID, "email-input").send_keys("testuser@example.com")
    driver.find_element(By.ID, "password-input").send_keys("test1234")
    driver.find_element(By.ID, "password-confirmation-input").send_keys("test1234")

    role_select = driver.find_element(By.ID, "input-role")
    for option in role_select.find_elements(By.TAG_NAME, "option"):
        if option.get_attribute("value") == "cashier":
            option.click()
            break

    # Klik label agar checkbox ikut tercentang
    label = driver.find_element(By.CSS_SELECTOR, "label[for='agreeTerms']")
    label.click()

    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()

    WebDriverWait(driver, 10).until(EC.url_contains("/dashboard"))
    assert "/dashboard" in driver.current_url


def test_login_success(driver, base_url):
    driver.get(f"{base_url}/login")

    driver.find_element(By.ID, "input-email").send_keys("admin@mail.com")
    driver.find_element(By.ID, "input-password").send_keys("test123")
    driver.find_element(By.ID, "button-login").click()

    time.sleep(1)
    assert "/admin/dashboard" in driver.current_url


def test_login_failure(driver, base_url):
    driver.get(f"{base_url}/login")

    driver.find_element(By.ID, "input-email").send_keys("salah@mail.com")
    driver.find_element(By.ID, "input-password").send_keys("salahbanget")
    driver.find_element(By.ID, "button-login").click()

    alert = driver.find_element(By.CLASS_NAME, "alert").text
    assert "credentials do not match" in alert.lower()

def test_logout(driver, base_url):
    driver.get(f"{base_url}/login")

    driver.find_element(By.ID, "input-email").send_keys("admin@mail.com")
    driver.find_element(By.ID, "input-password").send_keys("test123")
    driver.find_element(By.ID, "button-login").click()

    WebDriverWait(driver, 10).until(EC.url_contains("/admin/dashboard"))

    try:
        menu_toggle = WebDriverWait(driver, 3).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "a[data-widget='pushmenu']"))
        )
        menu_toggle.click()
    except:
        pass

    logout_link = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.PARTIAL_LINK_TEXT, "Logout"))
    )
    ActionChains(driver).move_to_element(logout_link).click().perform()

    WebDriverWait(driver, 10).until(EC.url_contains("/login"))
    assert "/login" in driver.current_url
