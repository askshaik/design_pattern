#include <fstream>
#include <iostream>

#include <boost/archive/text_oarchive.hpp>
#include <boost/archive/text_iarchive.hpp>
using namespace std;

class gps_position
{
    friend class boost::serialization::access;
    friend ostream& operator<< (ostream &co, const gps_position &g);
    // When the class Archive corresponds to an output archive, the
    // & operator is defined similar to <<.  Likewise, when the class Archive
    // is a type of input archive the & operator is defined similar to >>.
    template<class Archive>
    void serialize(Archive & ar, const unsigned int version)
    {
        ar & degrees;
        ar & minutes;
        ar & seconds;
    }

    int degrees;
    int minutes;
    float seconds;
public:
    gps_position(int d, int m, float s) :
        degrees(d), minutes(m), seconds(s) {}
};
ostream& operator<< (ostream &co, const gps_position &g) {
	return co << g.degrees << "," << g.minutes << "," << g.seconds;
}
void serialization_main() {
    // create and open a character archive for output
    std::ofstream ofs("ser.txt");

    // create class instance
    gps_position g1(1, 2, 3.0f), g2(4, 5, 6.0f);
    cout << g1 << endl << g2 << endl;
    // save data to archive
    {
        boost::archive::text_oarchive oa(ofs);
        oa << g1 << g2;
    }

    // ... some time later restore the class instance to its orginal state
    gps_position newg1(0,0,0), newg2(0,0,0);
    {
        // create and open an archive for input
        std::ifstream ifs("ser.txt");
        boost::archive::text_iarchive ia(ifs);
        ia >> newg1 >> newg2;
    }
    cout << newg1 << endl << newg2 << endl;
}
