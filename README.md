# Symfony E-Commerce Architecture Overview

This project implements a clean, SOLID-compliant architecture designed around the **Interface → Strategy → Handler** pattern.

## Core Architectural Principles

- **Strict Typing:** `declare(strict_types=1)` is used in all PHP files.
- **Service Immutability:** Services are declared as `final readonly` to prevent inheritance and ensure state immutability.
- **Dependency Inversion:** Controllers depend on Handlers and Fetchers, which in turn depend on Interfaces, not concrete implementations.
- **DTO Validation:** Data Transfer Objects (DTOs) are used for handling requests, with custom validation constraints.

## Account Module Architecture

The `Account` module handles user registration using a Factory and Persister strategy orchestrated by a Handler.

```mermaid
classDiagram
    class RegisterController {
        +register(Request, AccountHandler) Response
    }
    class AccountHandler {
        +handleRegistration(RegistrationRequest) void
    }
    class AccountFactoryInterface {
        <<interface>>
        +createFromRequest(RegistrationRequest) User
    }
    class DefaultAccountFactory {
        +createFromRequest(RegistrationRequest) User
    }
    class AccountPersisterInterface {
        <<interface>>
        +persist(User) void
    }
    class DefaultAccountPersister {
        +persist(User) void
    }

    RegisterController --> AccountHandler
    AccountHandler --> AccountFactoryInterface
    AccountHandler --> AccountPersisterInterface
    AccountFactoryInterface <|.. DefaultAccountFactory
    AccountPersisterInterface <|.. DefaultAccountPersister
```

## Cart Module Architecture

The `Cart` module delegates persistence and business logic to strategies, allowing for seamless switching between Session-based, API-based, or Database-backed carts.

```mermaid
classDiagram
    class CartController {
        +cart() Response
        +addToCart(int, Request, ProductRepository) Response
    }
    class CartHandler {
        +addToCart(CartItem, CartStrategyInterface) Cart
        +removeFromCart(CartItem, CartStrategyInterface) Cart
        +getCart(CartStrategyInterface) Cart
    }
    class CartStrategyInterface {
        <<interface>>
        +add(CartItem, Cart) Cart
        +remove(CartItem, Cart) Cart
        +getCart(string) Cart
        +clearCart(string) void
    }
    class DefaultCartStrategy {
        +add(CartItem, Cart) Cart
        +remove(CartItem, Cart) Cart
        +getCart(string) Cart
    }
    class CartPersisterInterface {
        <<interface>>
        +saveCart(Cart) void
        +saveItem(CartItem) void
    }

    CartController --> CartHandler
    CartController --> CartStrategyInterface
    CartHandler --> CartStrategyInterface
    CartStrategyInterface <|.. DefaultCartStrategy
    DefaultCartStrategy --> CartPersisterInterface
```
