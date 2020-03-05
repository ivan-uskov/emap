# Production

Содержание:

* [Summary](#summary)
  * [Issue](#issue)
  * [Decision](#decision)
  * [Status](#status)
* [Details](#details)
  * [Assumptions](#assumptions)
  * [Сonstraints](#constraints)
  * [Positions](#positions)
  * [Argument](#argument)
  * [Implications](#implications)
* [Related](#related)
  * [Related decisions](#related-decisions)
  * [Related requirements](#related-requirements)
  * [Related artifacts](#related-artifacts)
  * [Related principles](#related-principles)
* [Notes](#notes)


## Summary

### Issue

Нужно выбрать frontend стек:

  * Должны быть простые инструменты, которые знают все разработчики
  * Должен быть большой набор красивых компонентов


### Decision

Выбран Bootstrap.


### Status

Bootstrap решает поставленные задачи. Если появится более красивый фреймворк можно переехать на него.

## Details

### Assumptions

Нужно реализовать UI приложения. Максимально быстро, просто и красиво.

### Constraints

Нужно решение с готовым набором красивых компонентов.

### Positions

Реализовывать самостоятельно. Долго, породить большой объем тестирования.

Использовать MDL. Легок в использовании. Но перестал поддерживаться

Использовать Bootstap. Легок в использовании. Красивые компоненты. Есть опыт в применении.

### Argument

Bootstap наиболее подходящее решение, поскольку есть опыт и применении. UI приемлимый.

### Implications

Правильный выбор позволит съэкономить время на разработку frontend.
