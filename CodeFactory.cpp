#include <iostream>
#include <stdexcept>
using namespace std;
namespace factory {
	class Pizza {
	public:
		virtual ~Pizza() {}
		virtual void prepare() = 0;
		//Other functions like bake, cut and box can be added.
	};
	enum class Pizza_type { Cheese, Veggie, Peperoni, Spicy };
	class Pizza_factory {
	public:
		virtual Pizza *create_pizza(Pizza_type ty) = 0;
		virtual ~Pizza_factory() {};
	};

	class Mumbai_cheese_pizza : public Pizza {
	public: void prepare() override { cout << "Mumbai Cheese Pizza\n"; }
	};
	class Mumbai_veggie_pizza : public Pizza {
	public: void prepare() override { cout << "Mumbai Veggie Pizza\n"; }
	};
	class Mumbai_peperoni_pizza : public Pizza {
	public: void prepare() override { cout << "Mumbai peperoni Pizza\n"; }
	};
	class Mumbai_spicy_pizza : public Pizza {
	public: void prepare() override { cout << "Mumbai Spicy Pizza\n"; }
	};
	class Mumbai_pizza_factory : public Pizza_factory {
	public:
		Pizza *create_pizza(Pizza_type ty) override {
			if (ty == Pizza_type::Cheese) return new Mumbai_cheese_pizza();
			if (ty == Pizza_type::Veggie) return new Mumbai_veggie_pizza();
			if (ty == Pizza_type::Peperoni) return new Mumbai_peperoni_pizza();
			if (ty == Pizza_type::Spicy) return new Mumbai_spicy_pizza();
			throw logic_error("Invalid pizza type");
		}
	};

	class Pune_cheese_pizza : public Pizza {
	public: void prepare() override { cout << "Pune Cheese Pizza\n"; }
	};
	class Pune_veggie_pizza : public Pizza {
	public: void prepare() override { cout << "Pune Veggie Pizza\n"; }
	};
	class Pune_peperoni_pizza : public Pizza {
	public: void prepare() override { cout << "Pune peperoni Pizza\n"; }
	};
	class Pune_spicy_pizza : public Pizza {
	public: void prepare() override { cout << "Pune Spicy Pizza\n"; }
	};
	class Pune_pizza_factory : public Pizza_factory {
	public:
		Pizza *create_pizza(Pizza_type ty) override {
			if (ty == Pizza_type::Cheese) return new Pune_cheese_pizza();
			if (ty == Pizza_type::Veggie) return new Pune_veggie_pizza();
			if (ty == Pizza_type::Peperoni) return new Pune_peperoni_pizza();
			if (ty == Pizza_type::Spicy) return new Pune_spicy_pizza();
			throw logic_error("Invalid pizza type");
		}
	};

	class Cheese_pizza : public Pizza {
	public: void prepare() override { cout << "Cheese Pizza\n"; }
	};
	class Veggie_pizza : public Pizza {
	public: void prepare() override { cout << "Veggie Pizza\n"; }
	};
	class Peperoni_pizza : public Pizza {
	public: void prepare() override { cout << "Peperoni Pizza\n"; }
	};
	class Spicy_pizza : public Pizza {
	public: void prepare() override { cout << "Spicy Pizza\n"; }
	};
	class Default_pizza_factory : public Pizza_factory {
	public:
		Pizza *create_pizza(Pizza_type ty) override {
			if (ty == Pizza_type::Cheese) return new Cheese_pizza();
			if (ty == Pizza_type::Veggie) return new Veggie_pizza();
			if (ty == Pizza_type::Peperoni) return new Peperoni_pizza();
			if (ty == Pizza_type::Spicy) return new Spicy_pizza();
			throw logic_error("Invalid pizza type");
		}
	};

	enum class Location { Mumbai, Pune, Other };
	Pizza_factory *pizza_factory_create(Location loc) {
		if (loc == Location::Mumbai) return new Mumbai_pizza_factory();
		if (loc == Location::Pune) return new Pune_pizza_factory();
		return new Default_pizza_factory();
	}
}

void factory_main() {
	using namespace factory;
	auto pizza_factory = pizza_factory_create(Location::Mumbai);
	auto pizza = pizza_factory->create_pizza(Pizza_type::Cheese);
	pizza->prepare();
	delete pizza;
	delete pizza_factory;
}
