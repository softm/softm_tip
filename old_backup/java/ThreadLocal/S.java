package test.threadlocal;

import java.util.Date;

class S {
    public static void main(String[] args) {
        A a = new A();
        a.a();
    }
}

class A {
    public void a() {
        Context.localI.set(0);
        Integer i = Context.localI.get();
        Context.localI.set(++i);
        System.out.println(this.getClass().getName() + " - " + Context.localI.get());
        B b = new B();
        b.b();
        Context.localI.remove();
    }
}

class B {
    public void b() {
        Integer i = Context.localI.get();
        Context.localI.set(++i);
        System.out.println(this.getClass().getName() + " - " + Context.localI.get());
        C c = new C();
        c.c();
    }
}

class C {
    public void c() {
        Integer i = Context.localI.get();
        Context.localI.set(++i);
        System.out.println(this.getClass().getName() + " - " + Context.localI.get());
    }
}