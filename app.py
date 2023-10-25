import asyncio
import requests
from playwright.async_api import async_playwright

async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch(headless=True)  # Можно выбрать другой браузер: firefox, webkit
        context = await browser.new_context()
        page = await context.new_page()

        # Начальный индекс элемента для клика
        click_index = 2
        page_number = 1

        while True:
        # Перейти на веб-сайт
            url = f'https://tgramsearch.com/?page={page_number}'
            await page.goto(url)

            # Получить все элементы с классом tg-channel-link
            channel_links = await page.query_selector_all('.tg-channel-link')

            # Проверить, есть ли элементы с данным классом и кликнуть на второй элемент
            if len(channel_links) >= 3:
                await channel_links[click_index].click()
                print('Кликнул на третий элемент с классом tg-channel-link.')
            else:
                print('Не найдено достаточно элементов с классом tg-channel-link.')

            # Дождаться, чтобы страница полностью загрузилась
            await page.wait_for_load_state('load')

            # Найти элемент с классом tg-channel-header и ждать появления ссылки
            channel_header = await page.wait_for_selector('.tg-channel-header a')

            if channel_header:
                # Получить значение атрибута href с помощью JavaScript
                link_href = await channel_header.evaluate('(element) => element.getAttribute("href")')
                link_text = await channel_header.inner_text()
                print('Ссылка (href):', link_href)
                print('Текст ссылки:', link_text)
            else:
                print('Элемент с классом tg-channel-header и ссылкой не найден.')

            category_element = await page.query_selector('.tg-channel-categories a')
        
            if category_element:
                category_text = await category_element.inner_text()
                print('Текст из тега <a> внутри <div> с классом tg-channel-categories:', category_text)
            else:
                print('Элемент не найден.')

            # Найти и спарсить текст из элемента с классом tg-user-count
            user_count_element = await page.query_selector_all('.tg-user-count')
            user_count_text = await user_count_element[0].inner_text()
            print('Текст из tg-user-count:', user_count_text)

            # Найти и спарсить текст из элемента с классом tg-channel-description
            channel_description_element = await page.query_selector_all('.tg-channel-description')
            channel_description_text = await channel_description_element[2].inner_text()
            print('Текст из tg-channel-description:', channel_description_text)

            # Найти и спарсить значение атрибута src из тега img внутри элемента с классом tg-channel-img
            img_element = await page.query_selector_all('.tg-channel-img img')
            img_src = await img_element[2].evaluate('(element) => element.getAttribute("src")')
            print('Значение атрибута src из tg-channel-img:', img_src)

            # Отправка POST-запроса
            url = "http://testcatalog.ru/api.php"
            data = {
                "user_count_text": user_count_text,
                "link_href": link_href,
                "link_text": link_text,
                "channel_description_text": channel_description_text,
                "img_src": img_src,
                "category_text": category_text
            }

            response = requests.post(url, data=data)
            click_index += 1
            if click_index == 32:
                page_number += 1
                click_index = 2

# Запустить асинхронную функцию
asyncio.get_event_loop().run_until_complete(main())
