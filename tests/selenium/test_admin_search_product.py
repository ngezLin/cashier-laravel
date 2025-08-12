from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class TestAdminSearchProduct:

    def login_as_admin(self, driver, base_url):
        """Helper method to login as admin"""
        driver.get(f"{base_url}/login")
        driver.find_element(By.ID, "input-email").send_keys("admin@mail.com")
        driver.find_element(By.ID, "input-password").send_keys("test123")
        driver.find_element(By.ID, "button-login").click()
        WebDriverWait(driver, 10).until(EC.url_contains("/admin/dashboard"))

        try:
            menu_toggle = WebDriverWait(driver, 3).until(
                EC.element_to_be_clickable((By.ID, "pushmenu"))
            )
            menu_toggle.click()
        except:
            pass

    def navigate_to_products(self, driver):
        """Helper method to navigate to products page"""
        view_products_link = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.PARTIAL_LINK_TEXT, "View Products"))
        )
        view_products_link.click()
        WebDriverWait(driver, 10).until(EC.url_contains("/admin/products"))

    def test_search_product(self, driver, base_url):
        """Test searching for a product"""
        self.login_as_admin(driver, base_url)
        self.navigate_to_products(driver)

        search_input = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "search-text"))
        )
        search_input.clear()
        search_input.send_keys("Test Product Selenium")
        search_input.send_keys("\n")

        WebDriverWait(driver, 10).until(
            lambda driver: "search" in driver.current_url.lower()
        )

        assert "Test Product Selenium" in driver.page_source
        assert "No products found" not in driver.page_source
