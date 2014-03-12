/**
 * 
 */
package com.tracking.kapal.restfull;

/**
 * @author Dwidasa
 *
 */
public interface AsyncTaskCompleteListener<T> {
	public void onTaskComplete(T... params);
}
