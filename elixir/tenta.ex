# tenta.ex
defmodule Tenta do
  @type binding() :: {atom(), any()}
  def lookup(nil, _) do nil end
  def lookup([{atom, value}|_], atom) do value end
  def lookup([_|t], atom) do lookup(t, atom) end

  def eval(list, {:var, atom}) do
    lookup(list, atom)
  end
  def eval(list, {:mul, expr1, expr2}) do
    eval(list, expr1) * eval(list, expr2)
  end
  def eval(list, {:add, expr1, expr2}) do
    eval(list, expr1) + eval(list, expr2)
  end
  def eval(_, {:const, value}) do value end

  def deriv({:const, _}, _) do 0 end
  def deriv({:var, x}, x) do 1 end
  def deriv({:var, _}, _) do 0 end
  def deriv({:add, expr1, expr2}, x) do
    {:add, deriv(expr1, x), deriv(expr2, x)}
  end
  def deriv({:mul, expr1, expr2}, x) do
    {:add, {:mul, deriv(expr1, x), expr2}, {:mul, expr1, deriv(expr2, x)}}
  end

  def inorder(nil, init, _op) do init end
  def inorder({:node, value, left, right}, init, op) do
    inorder(right, op.(value, inorder(left, init, op)), op)
  end

  def sum(nil) do 0 end
  def sum(tree) do
    inorder(tree, 0, fn a,b -> a + b end)
  end

  def reverse(list) do
    reverse(list, [])
  end
  def reverse([], list) do list end
  def reverse([h|t], list) do
    reverse(t, [h|list])
  end

  def append(list1, list2) do
    reverse(reverse(list1), list2)
  end
end
