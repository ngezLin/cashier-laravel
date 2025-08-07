from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import pytest

def test_login_success(driver, base_url):
    driver.get(f"{base_url}/login")

    driver.find_element(By.ID, "input-email").send_keys("admin@mail.com")
    driver.find_element(By.ID, "input-password").send_keys("test123")
    driver.find_element(By.ID, "button-login").click()

    time.sleep(3)
    assert "/admin/dashboard" in driver.current_url
