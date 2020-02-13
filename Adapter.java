package aPatternsCode;
import java.util.Arrays;
import java.util.Enumeration;
import java.util.Iterator;
import java.util.Vector;

class EnumeratorToIterator<E> implements Iterator<E>{
	private final Enumeration<E> en;
	public EnumeratorToIterator(Enumeration<E> en) {
		this.en = en;
	}
	@Override
	public boolean hasNext() {
		return en.hasMoreElements();
	}

	@Override
	public E next() {
		return en.nextElement();
	}
}


public class Adapter {
	public static void main(String[] args) {
		Vector<String> v = new Vector<>();
		v.addAll(Arrays.asList("a","b","c"));
		Iterator<String> en = new EnumeratorToIterator<String>(v.elements());
		while (en.hasNext())
			System.out.println(en.next());
	}
}

