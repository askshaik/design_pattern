#include <iostream>
#include <string>
using namespace std;
namespace cor {
	class Handler {
	protected:
		Handler *next;
	public:
		Handler(Handler *n) : next(n){}
		virtual void handle_request(string message) = 0;
		virtual ~Handler() { delete next;}
	};
	class Spam_handler : public Handler {
	public:
		Spam_handler(Handler *n) : Handler(n){}
		void handle_request(string message) override {
			if (message.find("yahoo.com") != string::npos)
				cout << "spam found\n";
			else
				next->handle_request(message);
		}
	};
	class Fan_handler : public Handler {
	public:
		Fan_handler(Handler *n) : Handler(n){}
		void handle_request(string message) override {
			if (message.find("great") != string::npos)
				cout << "Fan mail\n";
			else
				next->handle_request(message);
		}
	};
	class Complaint_handler : public Handler {
	public:
		Complaint_handler(Handler *n) : Handler(n){}
		void handle_request(string message) override {
			if (message.find("refund") != string::npos)
				cout << "Complaint mail\n";
			else
				next->handle_request(message);
		}
	};
	class Default_handler : public Handler {
	public:
		Default_handler() : Handler(nullptr){}
		void handle_request(string message) override {
			cout << "Email will be handled manually\n";
		}
	};
}
using namespace cor;
void process(Handler &h, char *email) {
	h.handle_request(email);
}
void cor_main() {
	Spam_handler sh ( new Fan_handler(new Complaint_handler(new Default_handler())));
	process(sh, "yahoo.com");
	process(sh, "great");
	process(sh, "refund");
	process(sh, "what is this?");
}
