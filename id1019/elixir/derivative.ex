# derivative.ex
defmodule Derivative do
  @type constant() :: {:const, number()} | {:const, atom()}
  @type literal() :: {:const, number()} | {:const, atom()} | {:var, atom()}
  @type expr() :: {:add, expr(), expr()} | {:mul, expr(), expr()} | literal()

  def deriv({:const, _}, _) do {:const, 0} end
  def deriv({:var, v}, v) do {:const, 1} end
  def deriv({:var, y}, _) do {:var, y} end
  def deriv({:mul, e1, e2}, v) do {:add, {:mul, deriv(e1, v), e2}, {:mul, e1, deriv(e2, v)}} end
  def deriv({:exp, {:var, v}, {:const, c}}, v) do {:mul, {:const, c}, {:exp, {:var, v}, {:const, c - 1}}} end
  def deriv({:add, e1, e2}, v) do {:add, deriv(e1, v), deriv(e2, v)} end
  def deriv({:logn, e}, _) do {:exp, e, {:const, -1}} end
  def deriv({:sqrt, e}, _) do {:mul, {:const, 0.5}, {:exp, e, {:const, -0.5}}} end
  def deriv({:sin, e}, _) do  {:cos, e} end

  def simplify({:const, e}) do {:const, e} end
  def simplify({:var, e}) do {:var, e} end
  def simplify({:mul, e1, e2}) do
    case simplify(e1) do
      {:const, 0} -> {:const, 0}
      {:const, 1} -> simplify(e2)
      {:var, _} ->
        case simplify(e2) do
          {:const, 0} -> {:const, 0}
          {:const, 1} -> simplify(e1)
          _ -> {:mul, simplify(e1), simplify(e2)}
        end
      _ -> {:mul, simplify(e1), simplify(e2)}
    end
  end
  def simplify({:add, e1, e2}) do
    case simplify(e1) do
      {:const, 0} -> simplify(e2)
      _ ->
        case simplify(e2) do
          {:const, 0} -> simplify(e1)
          _ -> {:add, simplify(e1), simplify(e2)}
        end
    end
  end
  def simplify({:exp, e1, e2}) do
    case simplify(e1) do
      {:const, 0} -> {:const, 0}
      _ ->
        case simplify(e2) do
          {:const, 0} -> {:const, 1}
          _ -> {:exp, simplify(e1), simplify(e2)}
        end
    end
  end

  def print({:const, c}) do IO.write("#{c}") end
  def print({:var, v}) do IO.write("#{v}") end
  def print({:mul, e1, e2}) do
    case e1 do
      {:const, 1} -> print(e2)
      _ ->
        case e2 do
          {:const, 1} -> print(e1)
          _ ->
          IO.write("(")
          print(e1)
          IO.write("*")
          print(e2)
          IO.write(")")
        end
    end
  end
  def print({:add, e1, e2}) do
    IO.write("(")
    print(e1)
    IO.write("+")
    print(e2)
    IO.write(")")
  end
  def print({:exp, e1, e2}) do
    print(e1)
    IO.write("^")
    print(e2)
  end
  def print({:cos, e}) do
    IO.write("cos(#{e})")
  end
  def print({:sqrt, e}) do
    IO.write("sqrt(#{e})")
  end
  def print({:logn, e}) do
    IO.write("ln(#{e})")
  end
end
