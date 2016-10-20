package md55387cf7d9460a5de76267ef89bc0ff08;


public class ErrorCheckActivity
	extends android.app.Activity
	implements
		mono.android.IGCUserPeer
{
/** @hide */
	public static final String __md_methods;
	static {
		__md_methods = 
			"";
		mono.android.Runtime.register ("CRRD.Resources.Activities.ErrorCheckActivity, CRRD, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null", ErrorCheckActivity.class, __md_methods);
	}


	public ErrorCheckActivity () throws java.lang.Throwable
	{
		super ();
		if (getClass () == ErrorCheckActivity.class)
			mono.android.TypeManager.Activate ("CRRD.Resources.Activities.ErrorCheckActivity, CRRD, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null", "", this, new java.lang.Object[] {  });
	}

	private java.util.ArrayList refList;
	public void monodroidAddReference (java.lang.Object obj)
	{
		if (refList == null)
			refList = new java.util.ArrayList ();
		refList.add (obj);
	}

	public void monodroidClearReferences ()
	{
		if (refList != null)
			refList.clear ();
	}
}
