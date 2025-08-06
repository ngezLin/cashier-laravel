from selenium import webdriver
from selenium.webdriver.common.by import By
import time

def test_login_success():
    driver = webdriver.Chrome()
    driver.get("http://cashier-laravel.test/login")

    driver.find_element(By.NAME, "email").send_keys("admin@mail.com")
    driver.find_element(By.NAME, "password").send_keys("test123")
    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()

    time.sleep(2)
    print("Login sukses? Sekarang di:", driver.current_url)
    driver.quit()

def test_login_failure():
    driver = webdriver.Chrome()
    driver.get("http://cashier-laravel.test/login")

    driver.find_element(By.NAME, "email").send_keys("salah@example.com")
    driver.find_element(By.NAME, "password").send_keys("salah")
    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()

    time.sleep(2)

    alert = driver.find_element(By.CLASS_NAME, "alert-danger").text
    print("Isi alert:", alert)
    assert "These credentials do not match" in alert
    driver.quit()

test_login_success()
test_login_failure()
